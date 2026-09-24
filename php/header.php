<header>
    <?php $usuarioActual = $_SESSION['usuario'] ?? 'usuario'; ?>
    <?php if (!empty($_SESSION['logueado']) && $_SESSION['logueado'] === true): ?>
        <h1>¡Bienvenido, <?php echo htmlspecialchars($usuarioActual, ENT_QUOTES, 'UTF-8'); ?>!</h1>
    <?php else: ?>
        <h1>BIENVENIDO A LA BIBLIOTECA</h1>
    <?php endif; ?>
    <p>Sistema de gestión de biblioteca</p>
    <img src="img/logo.png" class="img-fluid" alt="Escudo de la biblioteca">
    <hr>
</header>