<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/User.php';

class UserController {
    private $pdo;
    private $userModel;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/config.php';

        $host = $config['host'];
        $db = $config['db'];
        $user = $config['user'];
        $pass = $config['pass'];

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->userModel = new User($this->pdo);
        } catch (PDOException $e) {
            echo "Erro na conexão com o banco de dados: " . $e->getMessage();
            exit();
        }
    }

    public function index() {
        include '../app/views/header.php';
    }

    public function login() {
        if (isset($_SESSION['user_id'])) {
            header('Location: /profile');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $userId = $this->userModel->login($username, $password);
            if ($userId) {
                $_SESSION['user_id'] = $userId;
                $_SESSION['user'] = $username; 
                
                header('Location: /profile');
                exit();
            } else {
                echo "Nome de usuário ou senha inválidos.";
            }
        } else {
            include '../app/views/login.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->userModel->register($username, $password)) {
                header('Location: /login');
                exit();
            } else {
                echo "Erro ao registrar o usuário.";
            }
        } else {
            include '../app/views/register.php';
        }
    }

    public function profile() {
        
        if (!isset($_SESSION['user_id'])) {
            echo "Você precisa estar logado para ver esta página.";
            return;
        }

        
        $user = $this->userModel->getUserById($_SESSION['user_id']);

        
        include '../app/views/profile.php';
    }

    public function dashboard() {
        if (isset($_SESSION['user_id'])) {
        $user = $this->userModel->getUserById($_SESSION['user_id']);
    
        $usersPerMonth = $this->getUsersPerMonth();
        }
    
        include '../app/views/dashboard.php';
    }

    public function logout() {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();

        header('Location: /');
        exit();
    }

    public function getUsersPerMonth() {
        try {
            
            $stmt = $this->pdo->prepare("
                SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS count
                FROM users
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                ORDER BY DATE_FORMAT(created_at, '%Y-%m')
            ");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $data = [];
            $currentYear = date('Y');
            for ($i = 1; $i <= 12; $i++) {
                $month = sprintf('%04d-%02d', $currentYear, $i);
                $data[$month] = 0; 
            }
    
            foreach ($results as $row) {
                $data[$row['month']] = (int)$row['count'];
            }
    
            return [
                'months' => array_keys($data),
                'counts' => array_values($data),
            ];
    
        } catch (PDOException $e) {
            echo "Erro ao buscar usuários por mês: " . $e->getMessage();
            return ['months' => [], 'counts' => []];
        }
    }
}
