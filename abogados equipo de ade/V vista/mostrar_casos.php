<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/mostrar_abogados.css">
    <title>Lista de Casos</title>
</head>
<body>
    <h1>Lista de Casos</h1>
    <ul>
        <li><a href="index.html">Regresar</a></li>
        <li><a href="acceso_abogados.html">Mostrar Abogado</a></li>
        <li><a href="acceso_cliente.html">Mostrar Cliente</a></li>
        <li><a href="acceso_fiscal.html">Mostrar Fiscal</a></li>
    </ul>

    <table border="1">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Abogado</th>
                <th>Fiscal</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
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

            // Consultar los casos y unir las tablas relacionadas
            $sql = "
            SELECT 
                clientes.nombre AS cliente_nombre, clientes.apellido AS cliente_apellido,
                abogados.nombre AS abogado_nombre, abogados.apellido AS abogado_apellido,
                fiscales.nombre AS fiscal_nombre, fiscales.apellido AS fiscal_apellido,
                casos.fecha_inicio, casos.fecha_fin, casos.descripcion
            FROM casos
            INNER JOIN clientes ON casos.cliente_id = clientes.id
            INNER JOIN abogados ON casos.abogado_id = abogados.id
            INNER JOIN fiscales ON casos.fiscal_id = fiscales.id
        ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Salida de cada fila
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['cliente_nombre']) . " " . htmlspecialchars($row['cliente_apellido']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['abogado_nombre']) . " " . htmlspecialchars($row['abogado_apellido']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fiscal_nombre']) . " " . htmlspecialchars($row['fiscal_apellido']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fecha_inicio']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fecha_fin']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay casos registrados.</td></tr>";
            }

            // Cerrar conexión
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
