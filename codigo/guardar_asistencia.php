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

// Obtén los datos del formulario
$nombre = $_POST['nombres'];
$asistencia = $_POST['asistencia'];
$fechaHoraEntrada = $_POST['fechaHora'];
$fechaHoraSalida = $_POST['fechaHoraSalida'];

// Verifica que la hora de salida no sea anterior a la hora de entrada
if ($fechaHoraSalida < $fechaHoraEntrada) {
    echo '<script>alert("La Fecha y Hora de Salida no puede ser anterior a la Fecha y Hora de Entrada");window.location.href = "https://haciendamariscal.net/inicio"</script>';
    exit();
}

// Realiza una consulta para obtener el ID del usuario y verificar la asistencia para esa fecha
$sqlUserID = "SELECT IDUsuario FROM Usuarios WHERE Nombre = '$nombre'";
$resultUserID = $conn->query($sqlUserID);

if ($resultUserID->num_rows > 0) {
    $rowUserID = $resultUserID->fetch_assoc();
    $idUsuario = $rowUserID['IDUsuario'];

    // Verifica si el usuario ya ha registrado asistencia para esa fecha
    $sqlCheckExisting = "SELECT IDAsistencia FROM Asistencia WHERE IDUsuario = $idUsuario AND DATE(FechaHoraAsistencia) = DATE('$fechaHoraEntrada')";
    $resultCheckExisting = $conn->query($sqlCheckExisting);

    if ($resultCheckExisting->num_rows > 0) {
        echo '<script>alert("Este usuario ya ha registrado asistencia para la fecha seleccionada");window.location.href = "https://haciendamariscal.net/inicio"</script>';
    } else {
        // Inserta los datos en la tabla Asistencia
        $sqlInsert = "INSERT INTO Asistencia (IDUsuario, FechaHoraAsistencia, FechaHoraSalida, EstadoAsistencia) VALUES ($idUsuario, '$fechaHoraEntrada', '$fechaHoraSalida', $asistencia)";
        if ($conn->query($sqlInsert) === TRUE) {
            echo '<script>alert("Asistencia guardada con éxito");window.location.href = "https://haciendamariscal.net/inicio"</script>';
        } else {
            echo '<script>alert("Error al guardar la asistencia");window.location.href = "https://haciendamariscal.net/inicio"</script>';
        }
    }
} else {
    echo '<script>alert("Usuario no encontrado");window.location.href = "https://haciendamariscal.net/inicio"</script>';
}

// Cierra la conexión
$conn->close();
?>
