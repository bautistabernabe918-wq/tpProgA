<?php
session_start();

if (!empty($_SESSION['logueado']) && $_SESSION['logueado'] === true) {
    header('Location: inicio.php');
    exit;
}
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
<?php include("php/header.php"); ?>
<main>
<p class="frase">— Estamos en index.php —</p>
<a href="login.php">Iniciar sesión</a>
</main>
<?php include("php/footer.php"); ?>  
</body>
</html>