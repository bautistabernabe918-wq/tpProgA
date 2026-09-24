<?php
session_start();


$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';
$captchaIngresado = strtoupper(trim((string) ($_POST['captcha'] ?? '')));
$captchaGuardado = strtoupper((string) ($_SESSION['captcha'] ?? ''));

if ($captchaIngresado !== $captchaGuardado) {
    unset($_SESSION['captcha']);
    $_SESSION['error'] = 'Captcha incorrecto.';
    header('Location: loginfallido.php');
    exit;
}

$usuarios_validos = [
    'fcytuader' => 'programacionavanzada',
    'admin' => 'admin',
];

$password_correcta = $usuarios_validos[$usuario] ?? null;

if ($usuario !== '' && $password !== '' && $password === $password_correcta) {
    unset($_SESSION['captcha']);
    unset($_SESSION['error']);
    session_regenerate_id(true); // Regenerar el ID de sesión para mayor seguridad
    $_SESSION['logueado'] = true;
    $_SESSION['usuario'] = $usuario;

    header('Location: loginexitoso.php');
    exit;
}

unset($_SESSION['captcha']);
$_SESSION['error'] = 'Usuario o contraseña incorrectos.';

header('Location: loginfallido.php');
exit;


include("php/footer.php"); 
?>
