<?php
$host = 'localhost';
$dbname = 'mi_proyecto_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // Si abres este archivo directamente en el navegador, verás el mensaje de éxito.
    // Si lo incluyes desde otro archivo (ej. procesoLogin.php), no imprimirá nada para no romper redirecciones.
    if (isset($_SERVER['SCRIPT_FILENAME']) && basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
        echo "<h3 style='color: green;'>¡Conexión exitosa a la base de datos: <code>$dbname</code>!</h3>";
    }
} catch (PDOException $e) {
    die("<h3 style='color: red;'>Error en la conexión:</h3> " . $e->getMessage());
}
?>