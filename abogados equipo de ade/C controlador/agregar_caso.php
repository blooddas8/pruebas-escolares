<?php
// Configuración de la conexión a la base de datos
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'gestion_abogados';

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$cliente_id = intval($_POST['cliente']); // Asegurarse de que sea un entero
$abogado_id = intval($_POST['abogado']); // Asegurarse de que sea un entero
$fiscal_id = intval($_POST['fiscal']); // Asegurarse de que sea un entero
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$descripcion = $_POST['descripcion'];

// Verificar que los IDs no sean nulos
if (empty($cliente_id) || empty($abogado_id) || empty($fiscal_id)) {
    die("Error: Los IDs de cliente, abogado o fiscal no pueden estar vacíos.");
}

// Verificar si el cliente existe
$result_cliente = $conn->query("SELECT * FROM clientes WHERE id = $cliente_id");

if ($result_cliente === false) {
    die("Error en la consulta: " . $conn->error);
}

if ($result_cliente->num_rows == 0) {
    die("Error: El cliente con ID $cliente_id no existe.");
}

// Preparar la consulta para insertar datos
$stmt = $conn->prepare("INSERT INTO casos (cliente_id, abogado_id, fiscal_id, fecha_inicio, fecha_fin, descripcion) VALUES (?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Vincular los parámetros
$stmt->bind_param("iiisss", $cliente_id, $abogado_id, $fiscal_id, $fecha_inicio, $fecha_fin, $descripcion);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Caso agregado exitosamente.";
    header("Location:../V vista/agregar_caso.php");
    exit;
} else {
    echo "Error al agregar el caso: " . $stmt->error;
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>
