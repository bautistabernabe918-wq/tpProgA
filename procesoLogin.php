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

$recaptchaSecretKey = '6LdcS80tAAAAAGO6MuoLY2YOGnbuVJ-RNH2wIrbS';
$captchaValido = false;

if ($recaptchaSecretKey !== '6LdcS80tAAAAAGO6MuoLY2YOGnbuVJ-RNH2wIrbS' && $recaptchaResponse !== '') {
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($recaptchaSecretKey) . '&response=' . urlencode($recaptchaResponse));
    $captchaData = json_decode($verifyResponse, true);
    $captchaValido = !empty($captchaData['success']) && $captchaData['success'] === true;
}

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

