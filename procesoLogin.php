<?php
session_start();

$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';
$captchaIngresado = strtoupper(trim((string) ($_POST['captcha'] ?? '')));
$captchaGuardado = strtoupper((string) ($_SESSION['captcha'] ?? ''));

$usuarios_validos = [
    'fcytuader' => 'programacionavanzada',
    'admin' => 'admin',
];

$password_correcta = $usuarios_validos[$usuario] ?? null;
$captchaValido = ($captchaGuardado !== '' && $captchaIngresado === $captchaGuardado);
$credencialesValidas = ($usuario !== '' && $password !== '' && $password === $password_correcta);

// El captcha se usa una sola vez: se pide de nuevo en el próximo intento.
unset($_SESSION['captcha']);

if ($captchaValido && $credencialesValidas) {
    unset($_SESSION['error']);
    session_regenerate_id(true); // Regenerar el ID de sesión para mayor seguridad
    $_SESSION['logueado'] = true;
    $_SESSION['usuario'] = $usuario;

    header('Location: loginexitoso.php');
    exit;
}

if (!$captchaValido && $credencialesValidas) {
    $_SESSION['error'] = 'Captcha incorrecto.';
} else {
    $_SESSION['error'] = 'Usuario o contraseña incorrectos.';
}

header('Location: loginfallido.php');
exit;

