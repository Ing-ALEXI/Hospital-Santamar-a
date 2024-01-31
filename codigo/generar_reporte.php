<?php
// Este es el contenido de generar_reporte.php

// Incluye la biblioteca TCPDF
require('TCPDF-main/tcpdf.php');

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

// Obtén las asistencias de la última semana (ajusta según tu lógica de semana)
$sqlAsistencias = "SELECT U.IDUsuario, U.Nombre, A.FechaHoraAsistencia, A.FechaHoraSalida, A.EstadoAsistencia
        FROM Usuarios U
        LEFT JOIN Asistencia A ON U.IDUsuario = A.IDUsuario
        AND DATE(A.FechaHoraAsistencia) BETWEEN CURDATE() - INTERVAL 1 WEEK AND CURDATE()";

$resultAsistencias = $conn->query($sqlAsistencias);

if ($resultAsistencias->num_rows > 0) {
    // Crear el objeto TCPDF
    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

    // Añadir una página
    $pdf->AddPage();

    // Configurar fuente y tamaño de texto
    $pdf->SetFont('helvetica', '', 12);

    // Obtener el ancho de la página
    $pageWidth = $pdf->GetPageWidth();

    // Cabecera de la primera tabla
    $pdf->Cell($pageWidth, 10, 'Tabla de Asistencias', 0, 1, 'C');
    $pdf->SetFillColor(173, 216, 230); // Color de fondo de la cabecera
    $pdf->Cell($pageWidth / 7, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->Cell($pageWidth / 4, 10, 'Fecha y Hora de Asistencia', 1, 0, 'C', 1);
    $pdf->Cell($pageWidth / 4, 10, 'Fecha y Hora de Salida', 1, 0, 'C', 1);
    $pdf->Cell($pageWidth / 4, 10, 'Estado de Asistencia', 1, 1, 'C', 1);

    // Contenido de la primera tabla
    while ($row = $resultAsistencias->fetch_assoc()) {
        $pdf->Cell($pageWidth / 7, 10, $row['Nombre'], 1);
        $pdf->Cell($pageWidth / 4, 10, $row['FechaHoraAsistencia'], 1);
        $pdf->Cell($pageWidth / 4, 10, $row['FechaHoraSalida'], 1);
        $pdf->Cell($pageWidth / 4, 10, ($row['EstadoAsistencia'] == 1 ? 'Asistió' : 'No Asistió'), 1);
        $pdf->Ln();
    }

    // Espaciado entre las dos tablas
    $pdf->Ln(10);


    $pdf->Cell($pageWidth, 10, 'Tabla del total de Asistencias y Faltas', 0, 1, 'C');
    // Cabecera de la segunda tabla
    $pdf->SetFillColor(173, 216, 230); 
    // Color de fondo de la cabecera
    $pdf->Cell($pageWidth / 4, 10, 'Nombre', 1, 0, 'C', 1);
    $pdf->Cell($pageWidth / 3, 10, 'Asistencias', 1, 0, 'C', 1);
    $pdf->Cell($pageWidth / 3, 10, 'Faltas', 1, 1, 'C', 1);

    // Obtener información de asistencias y faltas
    $asistenciasFaltas = obtenerAsistenciasFaltas($conn);

    // Contenido de la segunda tabla
    foreach ($asistenciasFaltas as $info) {
        $pdf->Cell($pageWidth / 4, 10, $info['Nombre'], 1);
        $pdf->Cell($pageWidth / 3, 10, $info['Asistencias'], 1);
        $pdf->Cell($pageWidth / 3, 10, $info['Faltas'], 1);
        $pdf->Ln();
    }

    // Nombre del archivo
    $filename = 'Reporte_Semanal.pdf';

    // Salida del PDF (mostrar en el navegador)
    $pdf->Output($filename, 'I');

    echo 'PDF generado con éxito. <a href="' . $filename . '" target="_blank">Descargar PDF</a>';
} else {
    echo 'No hay asistencias registradas para la última semana.';
}

// Cierra la conexión
$conn->close();

// Función para obtener información de asistencias y faltas
function obtenerAsistenciasFaltas($conn) {
    $asistenciasFaltas = array();

    // Obtén las asistencias y faltas por usuario
    $sql = "SELECT U.Nombre,
            COUNT(CASE WHEN A.EstadoAsistencia = 1 THEN 1 END) AS Asistencias,
            COUNT(CASE WHEN A.EstadoAsistencia = 2 THEN 1 END) AS Faltas
            FROM Usuarios U
            LEFT JOIN Asistencia A ON U.IDUsuario = A.IDUsuario
            WHERE DATE(A.FechaHoraAsistencia) BETWEEN CURDATE() - INTERVAL 1 WEEK AND CURDATE()
            GROUP BY U.Nombre";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $asistenciasFaltas[] = array(
                'Nombre' => $row['Nombre'],
                'Asistencias' => $row['Asistencias'],
                'Faltas' => $row['Faltas']
            );
        }
    }

    return $asistenciasFaltas;
}
?>
