<?php
// Establece la conexión con la base de datos
$servername = "db5015110034.hosting-data.io";
$username = "dbu2953311";
$password = "Decimo-semestre_C_QN*";
$dbname = "dbs12533498";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtén todos los nombres de la tabla Usuarios
$sqlNombres = "SELECT Nombre FROM Usuarios";
$resultNombres = $conn->query($sqlNombres);

// Almacena los nombres en un array
$nombres = array();
if ($resultNombres->num_rows > 0) {
    while ($row = $resultNombres->fetch_assoc()) {
        $nombres[] = $row['Nombre'];
    }
}

// Realiza la consulta de asistencia para el día actual con JOIN en la tabla Usuarios
$sql = "SELECT A.FechaHoraAsistencia, A.FechaHoraSalida, A.EstadoAsistencia, U.Nombre 
        FROM Usuarios U
        LEFT JOIN Asistencia A ON U.IDUsuario = A.IDUsuario AND DATE(A.FechaHoraAsistencia) = CURDATE()";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Muestra la tabla de asistencia con estilos directos
    foreach ($nombres as $nombre) {
        $asistenciaEncontrada = false;

        while ($row = $result->fetch_assoc()) {
            if ($row['Nombre'] == $nombre) {
                $asistenciaEncontrada = true;

                $estadoClase = ($row['EstadoAsistencia'] == 1) ? 'asistio' : (($row['EstadoAsistencia'] == 2) ? 'no-asistio' : 'sin-registro');
                echo '<tr class="' . $estadoClase . '">';
                echo '<td>' . $row['Nombre'] . '</td>';
                echo '<td>' . $row['FechaHoraAsistencia'] . '</td>';
                echo '<td>' . $row['FechaHoraSalida'] . '</td>';
                echo '<td>' . ($row['EstadoAsistencia'] == 1 ? 'Asistió' : ($row['EstadoAsistencia'] == 2 ? 'No Asistió' : 'Sin Registro')) . '</td>';
                echo '</tr>';
                break;
            }
        }

        // Si no se encuentra asistencia para el nombre, mostrar la fila en gris
        if (!$asistenciaEncontrada) {
            echo '<tr class="sin-registro">';
            echo '<td>' . $nombre . '</td>';
            echo '<td> - </td>';
            echo '<td> - </td>';
            echo '<td> - </td>';
            echo '</tr>';
        }

        // Reinicia el puntero del resultado para la siguiente iteración
        mysqli_data_seek($result, 0);
    }
} else {
    // Si no hay asistencias registradas, mostrar todas las filas en gris
    foreach ($nombres as $nombre) {
        echo '<tr class="sin-registro">';
        echo '<td>' . $nombre . '</td>';
        echo '<td> - </td>';
        echo '<td> - </td>';
        echo '<td> - </td>';
        echo '</tr>';
    }
}

// Cierra la conexión
$conn->close();
?>
