
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Biblioteca</title>
</head>



<body>
<?php include("php/header.php"); ?>
<form action="procesologin.php" method="post">
    <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
    <input type="password" id="password" name="password" placeholder="Contraseña" required>
    <button type="submit" id="btnSubmit" disabled>Entrar</button>
</form>

<script src="scripLogin.js" type="text/javascript"></script>
<?php include("php/footer.php"); ?>  
</body>
</html>