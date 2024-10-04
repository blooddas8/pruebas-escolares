<?php
// Contraseña fija definida en el servidor
$contraseña_correcta = 'admin123'; // Cambia esto por la contraseña que prefieras

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la contraseña del formulario
    $password = $_POST['password'];

    // Verificar si la contraseña es correcta
    if ($password === $contraseña_correcta) {
        // Redirigir a la página de información protegida
        header("Location:../V vista/mostrar_cliente.php");
        exit;
    } else {
        // Mostrar mensaje de error
        echo "<h2>Contraseña incorrecta. Inténtalo de nuevo.</h2>";
    }
}
?>