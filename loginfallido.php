<?php
session_start();

$error = $_SESSION['error'] ?? 'Usuario o contraseña incorrectos.';
unset($_SESSION['error']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Biblioteca</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime(__DIR__ . '/css/style.css'); ?>">
</head>
<body>

<div class="resultado">

    <div class="ficha-resultado">
        <span class="sello sello--error">Acceso denegado</span>
        <p><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
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

</div>

<?php include("php/footer.php"); ?>
</body>
</html>