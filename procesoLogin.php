<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Biblioteca</title>
</head>
<body>
<?php


session_start();


$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';


$usuario_correcto = "fcytuader";
$password_correcta = "programacionavanzada";

// 4. Validar las credenciales
if ($usuario === $usuario_correcto && $password === $password_correcta) {
   
    $_SESSION['logueado'] = true;
    $_SESSION['usuario'] = $usuario;
    
    echo "¡Te logueaste bien! Bienvenido, " . htmlspecialchars($usuario);
} else {
    echo '
    <p>Usuario o contraseña incorrectos.</p>
    <p>Volviendo al inicio en <span id="contador">5</span> segundos...</p>

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

</body>
</html>