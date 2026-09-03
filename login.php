
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Biblioteca</title>
</head>

<h1> BIENVENIDO A LA BIBLIOTECA! </h1>
<br>
<h2> inicia sesion con tus credenciales </h2>
<br>

<body>


<form action="procesologin.php" method="post">
    <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
    <input type="password" id="password" name="password" placeholder="Contraseña" required>
    <button type="submit" id="btnSubmit" disabled>Entrar</button>
</form>


<script>

    const usuarioInput = document.getElementById('usuario');
    const passwordInput = document.getElementById('password');
    const btnSubmit = document.getElementById('btnSubmit');

    // Verifica que haya al menos una letra o número
    const contieneLetraONumero = /[a-zA-Z0-9]/;

    function validarCampos() {

        const usuarioValido =
            contieneLetraONumero.test(usuarioInput.value);

        const passwordValida =
            contieneLetraONumero.test(passwordInput.value);

        // Si los dos son válidos habilita el botón
        btnSubmit.disabled = !(usuarioValido && passwordValida);
    }

    usuarioInput.addEventListener('input', validarCampos);
    passwordInput.addEventListener('input', validarCampos);

</script>
  
</body>
</html>