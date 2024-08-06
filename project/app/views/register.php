<?php include '../app/views/header.php'; ?>

<div class="card">
    <h2 style="text-align: center;">Register</h2>
    <form action="/register" method="post">
        <div class="content">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="content">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="content">
            <button type="submit">Register</button>
        </div>
    </form>
</div>
