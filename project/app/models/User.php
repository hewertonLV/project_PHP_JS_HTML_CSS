<?php

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function register($username, $password) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
            if ($stmt->execute([
                ':username' => $username,
                ':password' => $hashedPassword
            ])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Log the error (optional)
            error_log("Erro ao registrar usuário: " . $e->getMessage());
            return false;
        }
    }

    public function login($username, $password) {
        try {
            $stmt = $this->pdo->prepare('SELECT id, password FROM users WHERE username = :username');
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                return $user['id'];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Log the error (optional)
            error_log("Erro ao fazer login: " . $e->getMessage());
            return false;
        }
    }

    public function getUserById($userId) {
        try {
            $stmt = $this->pdo->prepare('SELECT id, username FROM users WHERE id = :id');
            $stmt->execute([':id' => $userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log the error (optional)
            error_log("Erro ao buscar usuário: " . $e->getMessage());
            return false;
        }
    }
}
