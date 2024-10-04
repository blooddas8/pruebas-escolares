<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheer" href="../CSS/abogado.css">
    <link rel="stylesheet" href="../CSS/mostrar_abogados.css">
    <title>Lista de Abogados</title>
</head>
<body>
    <h1>Lista de Abogados</h1>
    <ul>
        <li><a href="index.html">Regresar</a></li>
        <li><a href="acceso_cliente.html">Mostrar Cliente</a></li>
        <li><a href="acceso_fiscal.html">Mostrar Fiscal</a></li>
        <li><a href="acceso_casos.html">Mostrar Caso</a></li>
    </ul>

    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Email</th>
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

            // Consultar la tabla abogados
            $sql = "SELECT nombre, apellido, direccion, telefono, email FROM abogados";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Salida de cada fila
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['apellido']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['direccion']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['telefono']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay abogados registrados.</td></tr>";
            }

            // Cerrar conexión
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
