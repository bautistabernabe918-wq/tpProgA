<?php
session_start();

$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';
$captchaIngresado = strtoupper(trim((string) ($_POST['captcha'] ?? '')));
$captchaGuardado = strtoupper((string) ($_SESSION['captcha'] ?? ''));

$usuario_correcto = 'fcytuader';
$password_correcta = 'programacionavanzada';

$captchaValido = ($captchaGuardado !== '' && $captchaIngresado === $captchaGuardado);
$credencialesValidas = ($usuario === $usuario_correcto && $password === $password_correcta);

// El captcha se usa una sola vez: se pida de nuevo en el próximo intento.
unset($_SESSION['captcha']);

if ($captchaValido && $credencialesValidas) {
    unset($_SESSION['error']);
    session_regenerate_id(true); // Regenerar el ID de sesión para mayor seguridad
    $_SESSION['logueado'] = true;
    $_SESSION['usuario'] = $usuario;

    header('Location: loginexitoso.php');
    exit;
}

// Si el captcha fue el único problema (usuario y contraseña correctos),
// se lo decimos puntualmente en vez de un mensaje genérico.
if (!$captchaValido && $credencialesValidas) {
    $_SESSION['error'] = 'Captcha incorrecto.';
} else {
    $_SESSION['error'] = 'Usuario o contraseña incorrectos.';
}

header('Location: loginfallido.php');
exit;

