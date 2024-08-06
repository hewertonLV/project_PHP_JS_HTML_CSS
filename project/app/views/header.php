<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(90deg, red, purple);
            background-size: cover;
            height: 100%;
            margin: 0;
        }

        .card {
            background-color: rgba(0, 0, 0, 0.8);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 40px;
            border-radius: 15px;
            color: white;
        }

        .content {
            padding: 5px;
        }

        nav {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 10px 0;
            text-align: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            display: inline-block;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
        }

        nav a:hover {
            background-color: #575757;
            color: #f4f4f4;
            border-radius: 5px;
        }

        .welcome-message {
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            color: #333;
        }

        .menu-container {
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <nav>
        <a href="/">Inicio</a>
        <?php if (isset($_SESSION['user_id'])) : ?>
            <a href="/profile">Perfil</a>
            <a href="/logout">Sair</a>
        <?php else : ?>
            <a href="/register">Registrar</a>
            <a href="/login">Entrar</a>
        <?php endif; ?>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</body>