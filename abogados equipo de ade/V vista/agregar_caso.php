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

// Obtener la lista de abogados
$result = $conn->query("SELECT id, nombre, apellido FROM abogados");
if ($result === false) {
    die("Error en la consulta: " . $conn->error);
}

$abogados = [];

// Si hay resultados, almacenarlos en el array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $abogados[] = [
            'id' => $row['id'],
            'nombre_completo' => $row['nombre'] . ' ' . $row['apellido'],
        ];
    }
} else {
    echo "No hay abogados disponibles.";
}

// Obtener la lista de fiscales
$result_fiscales = $conn->query("SELECT id, nombre, apellido FROM fiscales");
if ($result_fiscales === false) {
    die("Error en la consulta de fiscales: " . $conn->error);
}

$fiscales = [];

// Si hay resultados, almacenarlos en el array
if ($result_fiscales->num_rows > 0) {
    while ($row = $result_fiscales->fetch_assoc()) {
        $fiscales[] = [
            'id' => $row['id'],
            'nombre_completo' => $row['nombre'] . ' ' . $row['apellido'],
        ];
    }
} else {
    echo "No hay fiscales disponibles.";
}

// Consultar los clientes
$sql = "SELECT id, nombre, apellido FROM clientes";
$result_clientes = $conn->query($sql);
$conn->close(); // Cerrar conexión, no la necesitamos más aquí
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/caso.css">
    <link rel="stylesheet" href="../CSS/menu.css">
    <title>Agregar Caso</title>
    <script>
        function toggleOtherClientInput(selectElement) {
            const otherInput = document.getElementById('other-client');
            if (selectElement.value === 'otro') {
                otherInput.style.display = 'block';
            } else {
                otherInput.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <h1>Agregar Caso</h1>
    <ul>
        <li><a href="index.html">Regresar</a></li>
        <li><a href="agregar_abogado.html">Agregar Abogado</a></li>
        <li><a href="agregar_cliente.html">Agregar Cliente</a></li>
        <li><a href="agregar_fiscal.html">Agregar Fiscal</a></li>
    </ul>
    <form action="../C controlador/agregar_caso.php" method="POST">
        Cliente: 
        <select name="cliente" id="cliente" onchange="toggleOtherClientInput(this);" required>
            <option value="">Seleccionar Cliente</option>
            <?php if ($result_clientes->num_rows > 0): ?>
                <?php while ($row = $result_clientes->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['id']); ?>">
                        <?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?>
                    </option>
                <?php endwhile; ?>
            <?php else: ?>
                <option value="">No hay clientes registrados.</option>
            <?php endif; ?>
            <option value="otro">Otro</option> <!-- Opción "Otro" -->
        </select><br>

        <div id="other-client" style="display:none;">
            <label for="other-client-name">Nombre del Cliente (despues e agregar el nombre busque en el lustado):</label>
            <input type="text" name="other-client-name" id="other-client-name" placeholder="Ingrese el nombre del cliente">
        </div>

        Abogado: 
        <select name="abogado" required>
            <?php if (!empty($abogados)): ?>
                <?php foreach ($abogados as $abogado): ?>
                    <option value="<?php echo htmlspecialchars($abogado['id']); ?>">
                        <?php echo htmlspecialchars($abogado['nombre_completo']); ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">No hay abogados disponibles</option>
            <?php endif; ?>
        </select><br>

        Fiscal: 
        <select name="fiscal" required>
            <?php if (!empty($fiscales)): ?>
                <?php foreach ($fiscales as $fiscal): ?>
                    <option value="<?php echo htmlspecialchars($fiscal['id']); ?>">
                        <?php echo htmlspecialchars($fiscal['nombre_completo']); ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">No hay fiscales disponibles</option>
            <?php endif; ?>
        </select><br>

        Fecha de Inicio: <input type="date" name="fecha_inicio" required><br>
        Fecha de Fin: <input type="date" name="fecha_fin" required><br>
        Descripción: <textarea name="descripcion" required></textarea><br>
        <input type="submit" value="Agregar Caso">
    </form>
</body>
</html>
