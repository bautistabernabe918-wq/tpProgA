<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Biblioteca</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include("php/header.php"); ?>

<div class="resultado">
<?php


session_start();


$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';


$usuario_correcto = "fcytuader";
$password_correcta = "programacionavanzada";


if ($usuario === $usuario_correcto && $password === $password_correcta) {
   
    $_SESSION['logueado'] = true;
    $_SESSION['usuario'] = $usuario;
    
    echo '<div class="ficha-resultado">
        <span class="sello sello--ok">Acceso concedido</span>
        <p>¡Te logueaste bien! Bienvenido, ' . htmlspecialchars($usuario) . '</p>
    </div>';
} else {
    echo '
    <div class="ficha-resultado">
        <span class="sello sello--error">Acceso denegado</span>
        <p>Usuario o contraseña incorrectos.</p>
        <p>Volviendo al inicio en <span id="contador">5</span> segundos...</p>
    </div>

    <script>
        let segundos = 5;

        const intervalo = setInterval(function() {
            segundos--;
            document.getElementById("contador").textContent = segundos;

            if (segundos <= 0) {
                clearInterval(intervalo);
                window.location.href = "login.php";
            }
        }, 1000);
    </script>
';
}
?>
</div>

<?php include("php/footer.php"); ?>
</body>
</html>