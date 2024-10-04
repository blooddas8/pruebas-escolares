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
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    // Preparar y vincular la consulta
    $stmt = $conn->prepare("INSERT INTO abogados (nombre, apellido, direccion, telefono, email) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        die("Error al preparar la declaración: " . $conn->error);
        header("Location:../V vista/agregar_abogado.html");
        exit; // Asegúrate de usar exit después de header
    }

    $stmt->bind_param("sssss", $nombre, $apellido, $direccion, $telefono, $email);

    // Ejecutar la declaración
    if ($stmt->execute()) {
        echo "Abogado agregado exitosamente.";
        // Redirigir al formulario después de un éxito
        header("Location: ../V vista/agregar_abogado.html");
        exit; // Asegúrate de usar exit después de header
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>
