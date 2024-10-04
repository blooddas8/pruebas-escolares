<?php
// Configuración de la conexión a la base de datos
$servername = 'localhost';
$username = 'root'; // Cambia esto si tu usuario es diferente
$password = ''; // Cambia esto si tienes una contraseña
$dbname = 'gestion_abogados';

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario solo si se envía por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cargo = $_POST['cargo'];
    $institucion = $_POST['institucion'];

    // Preparar y vincular la consulta
    $stmt = $conn->prepare("INSERT INTO fiscales (nombre, apellido, cargo, institucion) VALUES (?, ?, ?, ?)");
    
    if ($stmt === false) {
        die("Error al preparar la declaración: " . $conn->error);
    }

    $stmt->bind_param("ssss", $nombre, $apellido, $cargo, $institucion);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        // Redirigir después de un éxito
        header("Location: ../V vista/agregar_fiscal.html?success=1");
        exit; // Asegúrate de usar exit después de header
    } else {
        // Redirigir después de un error
        header("Location: ../V vista/agregar_fiscal.html?error=" . urlencode($stmt->error));
        exit; // Asegúrate de usar exit después de header
    }

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>
