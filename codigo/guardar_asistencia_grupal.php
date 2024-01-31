<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Establece la conexión con la base de datos (ajusta los datos según tu configuración)
$servername = "db5015110034.hosting-data.io";
$username = "dbu2953311";
$password = "Decimo-semestre_C_QN*";
$dbname = "dbs12533498";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Realiza una consulta para obtener los nombres y IDs de Usuarios
$sql = "SELECT IDUsuario, Nombre FROM Usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Almacena los nombres y IDs en un array asociativo
    $usuarios = array();
    while ($row = $result->fetch_assoc()) {
        $usuarios[$row['Nombre']] = $row['IDUsuario'];
    }
} else {
    $usuarios = array();
}

// Cierra la conexión
$conn->close();

// Procesa el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Establece la conexión nuevamente
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica la conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Obtén la fecha y hora de entrada y salida del formulario
    $fechaHora = $_POST['fechaHora'];
    $fechaHoraSalida = $_POST['fechaHoraSalida'];

    // Verifica si ya existe asistencia para la fecha seleccionada
    $sqlCheckExisting = "SELECT IDAsistencia FROM Asistencia WHERE DATE(FechaHoraAsistencia) = DATE('$fechaHora')";
    $resultCheckExisting = $conn->query($sqlCheckExisting);

    if ($resultCheckExisting->num_rows > 0) {
        echo '<script>alert("Ya existe asistencia registrada para la fecha seleccionada");window.location.href = "https://haciendamariscal.net/inicio"</script>';
    } else {
        // Verifica si la hora de salida es mayor que la hora de entrada
        if ($fechaHoraSalida <= $fechaHora) {
            echo '<script>alert("La hora de salida debe ser mayor que la hora de entrada");window.location.href = "https://haciendamariscal.net/inicio"</script>';
        } else {
            // Prepara la consulta para la inserción
            $sqlInsert = "INSERT INTO Asistencia (IDUsuario, FechaHoraAsistencia, FechaHoraSalida, EstadoAsistencia) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sqlInsert);

            // Vincula los parámetros
            $stmt->bind_param("isss", $idUsuario, $fechaHora, $fechaHoraSalida, $asistencia);

            // Itera sobre los usuarios para guardar la asistencia
            foreach ($usuarios as $nombre => $idUsuario) {
                $asistencia = $_POST['asistencia_' . $nombre] == '1' ? 1 : 2; // Si es '1', entonces 1; de lo contrario, 2

                // Ejecuta la consulta preparada
                $stmt->execute();
            }

            // Cierra la conexión
            $stmt->close();
            $conn->close();

            // Muestra la notificación y redirige
            echo '<script>alert("Asistencias guardadas con éxito");window.location.href = "https://haciendamariscal.net/inicio"</script>';
        }
    }
}
?>
