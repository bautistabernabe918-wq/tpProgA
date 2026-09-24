<?php
session_start();

if (empty($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Biblioteca - Inicio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime(__DIR__ . '/css/style.css'); ?>">
</head>

<body>
<?php include("php/header.php"); ?>
<main class="home-hero">
  <p class="bienvenida-central">¡Bienvenido <?php echo htmlspecialchars($_SESSION['usuario'] ?? 'usuario', ENT_QUOTES, 'UTF-8'); ?>!, ¿que vamos a leer hoy?</p>
</main>
<?php include("php/footer.php"); ?>  
</body>
</html>