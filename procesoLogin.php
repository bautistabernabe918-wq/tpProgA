<?php
session_start();

require_once __DIR__ . '/php/conexion.php';

$usuario = trim($_POST['usuario'] ?? '');
$password = $_POST['password'] ?? '';
$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

// Validación de credenciales contra la base de datos usando hash
$credencialesValidas = false;
$usuarioDb = null;

if ($usuario !== '' && $password !== '') {
    $stmt = $pdo->prepare('SELECT id, usuario, password FROM usuarios WHERE usuario = :usuario LIMIT 1');
    $stmt->execute([':usuario' => $usuario]);
    $usuarioDb = $stmt->fetch();

    if ($usuarioDb && password_verify($password, $usuarioDb['password'])) {
        $credencialesValidas = true;
    }
}

$recaptchaSecretKey = '6Le1TM0tAAAAAFlzM3X-jchqnZOlonf3aeP4jIPy';
$captchaValido = false;

if ($recaptchaResponse !== '') {
    $verifyResponse = @file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($recaptchaSecretKey) . '&response=' . urlencode($recaptchaResponse));
    $captchaData = json_decode($verifyResponse, true);
    $captchaValido = !empty($captchaData['success']) && $captchaData['success'] === true;
}

if ($captchaValido && $credencialesValidas) {
    unset($_SESSION['error']);
    session_regenerate_id(true);
    $_SESSION['logueado'] = true;
    $_SESSION['usuario'] = $usuarioDb['usuario'];
    $_SESSION['usuario_id'] = $usuarioDb['id'];

    header('Location: loginexitoso.php');
    exit;
}

if ($recaptchaResponse !== '' && !$captchaValido) {
    $_SESSION['error'] = 'Captcha incorrecto. Intentalo de nuevo.';
} elseif (!$credencialesValidas) {
    $_SESSION['error'] = 'Usuario o contraseña incorrectos.';
}

header('Location: login.php');
exit;

