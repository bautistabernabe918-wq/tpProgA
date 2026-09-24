<?php
session_start();

$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';
$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

$usuarios_validos = [
    'fcytuader' => 'programacionavanzada',
    'admin' => 'admin',
];

$password_correcta = $usuarios_validos[$usuario] ?? null;
$credencialesValidas = ($usuario !== '' && $password !== '' && $password === $password_correcta);

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
    $_SESSION['usuario'] = $usuario;

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

