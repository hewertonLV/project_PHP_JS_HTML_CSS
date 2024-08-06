<?php include '../app/views/header.php'; ?>

<div class="card">
    
    <?php if (isset($_SESSION['user'])): ?>
        <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user']); ?>!</p>
    <?php else: ?>
        <p>Você precisa estar logado para ver esta página.</p>
    <?php endif; ?>
</div>
