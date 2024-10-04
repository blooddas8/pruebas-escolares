<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root"; // Asegúrate de usar el usuario correcto
$password = ""; // Asegúrate de usar la contraseña correcta (dejar vacío si no hay)
$dbname = "gestion_abogados"; // Cambia esto a tu nombre de base de datos real

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
