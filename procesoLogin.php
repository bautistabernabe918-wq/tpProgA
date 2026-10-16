<?php
session_start();

require_once __DIR__ . '/php/conexion.php';

$usuario = trim($_POST['usuario'] ?? '');
$password = $_POST['password'] ?? '';
$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

// Validación de credenciales contra la base de datos usando hash
$credencialesValidas = false;
$usuarioDb = null;

if ($usuario !== '' && $password !== '') {
    $stmt = $pdo->prepare('SELECT id, usuario, password FROM usuarios WHERE usuario = :usuario LIMIT 1');
    $stmt->execute([':usuario' => $usuario]);
    $usuarioDb = $stmt->fetch();


if ($usuario === $usuario_correcto && $password === $password_correcta) {
   
    $_SESSION['logueado'] = true;
    $_SESSION['usuario'] = $usuario;
    
    echo '<div class="ficha-resultado">
        <span class="sello sello--ok">Acceso concedido</span>
        <p>¡Te logueaste bien! Bienvenido, ' . htmlspecialchars($usuario) . '</p>
    </div>';

    // Etapa 2: pantalla ficticia de "créditos agotados"
    
    echo <<<'HTML'
    <div class="panel-premium oculto" id="panelPremium">
        <p class="panel-premium__titulo">Has agotado tus créditos gratuitos.</p>
        <p class="panel-premium__subtitulo">Para continuar utilizando la Biblioteca, necesitás adquirir un plan premium.</p>

        <div class="planes">
            <div class="plan">
                <div class="plan__info">
                    <span class="plan__nombre">Plan Estudiante</span>
                    <span class="plan__precio">$4.999 / mes</span>
                </div>
                <button type="button" class="plan__boton">Obtener Premium</button>
            </div>
            <div class="plan">
                <div class="plan__info">
                    <span class="plan__nombre">Plan Investigador</span>
                    <span class="plan__precio">$9.999 / mes</span>
                </div>
                <button type="button" class="plan__boton">Obtener Premium</button>
            </div>
            <div class="plan">
                <div class="plan__info">
                    <span class="plan__nombre">Plan UADER Premium</span>
                    <span class="plan__precio">$19.999 / mes</span>
                </div>
                <button type="button" class="plan__boton">Obtener Premium</button>
            </div>
        </div>

        <p class="panel-premium__mensaje" id="mensajePago" aria-live="polite">&nbsp;</p>

        <p class="panel-premium__letra-chica">
            Los pagos son procesados por el Departamento de Cobros Imaginarios de la Biblioteca.<br>
            Oferta válida hasta que el programador termine el proyecto.
        </p>

        <a href="index.php" class="panel-premium__volver">Volver al inicio</a>
    </div>

    <script>
    (function () {
        var ficha = document.querySelector('.ficha-resultado');
        var panel = document.getElementById('panelPremium');
        var mensaje = document.getElementById('mensajePago');

        var frasesError = [
            'Error 402: todavía no sabemos cómo cobrarte.',
            'El dinero ha sido enviado. Lamentablemente, a otra biblioteca.',
            'Tu tarjeta fue rechazada por falta de existencia.'
        ];

        document.querySelectorAll('.plan__boton').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var frase = frasesError[Math.floor(Math.random() * frasesError.length)];
                mensaje.textContent = frase;
                mensaje.classList.remove('mostrar');
                void mensaje.offsetWidth; // reflow para poder repetir la animación
                mensaje.classList.add('mostrar');
            });
        });

        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function mostrarPanel() {
            if (ficha) {
                ficha.style.display = 'none';
            }
            panel.classList.remove('oculto');
            void panel.offsetWidth; // reflow antes de animar la entrada
            panel.classList.add('visible');
        }

      
        setTimeout(function () {
            if (!ficha || reduceMotion) {
                mostrarPanel();
                return;
            }

           
            ficha.style.animation = 'none';
            ficha.classList.add('saliendo');

            
            setTimeout(mostrarPanel, 450);
        }, 2500);
    })();
    </script>
HTML;
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
                window.location.href = "index.php";
            }
        }, 1000);
    </script>
';
}

$recaptchaSecretKey = '6Le1TM0tAAAAAFlzM3X-jchqnZOlonf3aeP4jIPy';
$captchaValido = false;

if ($recaptchaResponse !== '') {
    $verifyResponse = @file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($recaptchaSecretKey) . '&response=' . urlencode($recaptchaResponse));
    $captchaData = json_decode($verifyResponse, true);
    $captchaValido = !empty($captchaData['success']) && $captchaData['success'] === true;
}

if ($captchaValido && $credencialesValidas) {
    unset($_SESSION['error']);
    session_regenerate_id(true);
    $_SESSION['logueado'] = true;
    $_SESSION['usuario'] = $usuarioDb['usuario'];
    $_SESSION['usuario_id'] = $usuarioDb['id'];

    header('Location: loginexitoso.php');
    exit;
}

if ($recaptchaResponse !== '' && !$captchaValido) {
    $_SESSION['error'] = 'Captcha incorrecto. Intentalo de nuevo.';
} elseif (!$credencialesValidas) {
    $_SESSION['error'] = 'Usuario o contraseña incorrectos.';
}

header('Location: login.php');
exit;

