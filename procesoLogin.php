<?php
/**
 * ============================================================================
 *  procesoLogin.php
 *  Procesa el formulario de Login.
 *    1) Valida el reCAPTCHA contra Google.
 *    2) Valida usuario/contraseña contra la tabla `usuarios` de la BD.
 *    3) Si la BD no responde, muestra un mensaje amigable (no hay crash).
 * ============================================================================
 */

declare(strict_types=1);

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/modelos/Usuario.php';

$usuario           = trim((string) ($_POST['usuario'] ?? ''));
$password          = (string) ($_POST['password'] ?? '');
$recaptchaResponse = (string) ($_POST['g-recaptcha-response'] ?? '');

/* ---------------------------------------------------------------------------
 * 1) Validación del reCAPTCHA
 * ------------------------------------------------------------------------- */
$recaptchaSecretKey = '6Le1TM0tAAAAAFlzM3X-jchqnZOlonf3aeP4jIPy';
$captchaValido = false;

if ($recaptchaResponse !== '') {
    $verifyResponse = @file_get_contents(
        'https://www.google.com/recaptcha/api/siteverify?secret='
        . urlencode($recaptchaSecretKey)
        . '&response=' . urlencode($recaptchaResponse)
    );
    $captchaData   = json_decode((string) $verifyResponse, true);
    $captchaValido = !empty($captchaData['success']) && $captchaData['success'] === true;
}

if (!$captchaValido) {
    $_SESSION['error'] = $recaptchaResponse === ''
        ? 'Por favor, completá el captcha.'
        : 'Captcha incorrecto. Intentalo de nuevo.';
    header('Location: login.php');
    exit;
}

/* ---------------------------------------------------------------------------
 * 2) Validación de credenciales contra la BASE DE DATOS
 *    Se capturan de forma robusta los errores de conexión/consulta.
 * ------------------------------------------------------------------------- */
try {
    $pdo        = obtenerConexion();
    $modeloUser = new Usuario($pdo);
    $datosUser  = $modeloUser->validarCredenciales($usuario, $password);
} catch (ConexionBDException $e) {
    // Servidor caído, credenciales de BD mal, puerto bloqueado, etc.
    // mostrarErrorConexion() responde con un mensaje amigable y termina.
    mostrarErrorConexion();
} catch (PDOException $e) {
    // Falla a nivel de consulta (por ejemplo, tabla inexistente).
    error_log('[Login] Error de consulta: ' . $e->getMessage());
    $_SESSION['error'] = MENSAJE_ERROR_CONEXION;
    header('Location: login.php');
    exit;
}

/* ---------------------------------------------------------------------------
 * 3) Resultado de la autenticación
 * ------------------------------------------------------------------------- */
if ($datosUser !== null) {
    unset($_SESSION['error']);
    session_regenerate_id(true);       // evita fijación de sesión

    $_SESSION['logueado']   = true;
    $_SESSION['usuario']    = $datosUser['usuario'];
    $_SESSION['usuario_id'] = (int) $datosUser['id'];
    $_SESSION['rol']        = $datosUser['rol'];

    header('Location: loginexitoso.php');
    exit;
}

// Credenciales inválidas.
$_SESSION['error'] = 'Usuario o contraseña incorrectos.';
header('Location: login.php');
exit;
