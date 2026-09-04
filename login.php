
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
<main>
<form action="procesologin.php" method="post">
    <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
    <input type="password" id="password" name="password" placeholder="Contraseña" required>
    <button type="submit" id="btnSubmit" disabled>Entrar</button>
</form>
</main>

<script src="scripLogin.js" type="text/javascript"></script>
<?php include("php/footer.php"); ?>  
</body>
</html>

