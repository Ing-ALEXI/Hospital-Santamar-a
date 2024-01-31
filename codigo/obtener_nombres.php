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

// Realiza una consulta para obtener los nombres
$sql = "SELECT Nombre FROM Usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Almacena los nombres en un array
    $nombres = array();
    while ($row = $result->fetch_assoc()) {
        $nombres[] = $row['Nombre'];
    }

    // Devuelve los nombres como JSON
    $response = array('nombres' => $nombres);
} else {
    $response = array('nombres' => array());
}

// Cierra la conexión
$conn->close();

// Devuelve la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
