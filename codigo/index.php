<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Santamaría</title>
      <link rel="icon" href="https://hospitalsantamaria.com.ec/images/icon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Obtén el elemento del campo de fecha y hora del formulario 1
            var fechaHoraInput = document.getElementById('fechaHora');
            // Obtén el elemento del campo de fecha y hora del formulario 2
            var fechaHoraInput2 = document.getElementById('fechaHora2');

            // Obtén la fecha y hora actuales en UTC
            var fechaHoraActualUTC = new Date();

            // Ajusta la zona horaria a Guayaquil (UTC-5)
            fechaHoraActualUTC.setUTCHours(fechaHoraActualUTC.getUTCHours() - 5);

            // Formatea la fecha y hora actual en un formato compatible con el campo datetime-local
            var formatoFechaHoraActualGuayaquil = fechaHoraActualUTC.toISOString().slice(0, 16);

            // Establece la fecha y hora actuales en los campos correspondientes
            fechaHoraInput.value = formatoFechaHoraActualGuayaquil;
            fechaHoraInput2.value = formatoFechaHoraActualGuayaquil;

            // Función para obtener y llenar los nombres en el select
            function cargarNombres() {
                fetch('obtener_nombres.php')
                    .then(response => response.json())
                    .then(data => {
                        const nombresSelect = document.getElementById('nombres');

                        // Limpia el select
                        nombresSelect.innerHTML = '';

                        // Llena el select con los nombres obtenidos
                        data.nombres.forEach(nombre => {
                            const option = document.createElement('option');
                            option.value = nombre;
                            option.textContent = nombre;
                            nombresSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error al obtener nombres:', error);
                    });
            }

            // Llama a la función para cargar los nombres al cargar la página
            cargarNombres();
        });


    </script>


    <div class="header-container">
        <img src="https://hospitalsantamaria.com.ec/media/repo-img/imgweb-20230110163144147.png" id="img-header" alt="Logo" class="header-image">
    </div>
    <nav>
        <ul>
            <li><a href="#" onclick="mostrarContenido('registro')">Registro de Asistencia</a></li>
            <li><a href="#" onclick="mostrarContenido('asistencia')">Asistencia</a></li>
            <li><a href="#" onclick="mostrarContenido('reporte')">Reporte semanal</a></li>
        </ul>
    </nav>
    <div class="container">
        <!-- Contenedor para Registro de Asistencia -->
        <section class="content" id="registro">
            <button onclick="mostrarFormulario('form1')">Registro individual</button>
            <button onclick="mostrarFormulario('form2')">Registro Grupal</button>
            <div id="formulario1" style="display: block;">
                <form id="form1" class="attendance-form" action="guardar_asistencia.php" method="post">
                    <div class="campo">
                        <label for="nombres">Seleccione usuario:</label>
                        <select id="nombres" name="nombres" required></select>
                    </div>

                    <div class="campo">
                        <label>Asistencia:</label>
                        <div class="asistencia-checkboxes">
                            <div class="checkbox-container" id="asis">
                            <input type="checkbox" id="asistio" name="asistencia" value="1" class="asistencia-checkbox" >Si

                            </div>
                            <div class="checkbox-container" id="noasis">
                            <input type="checkbox" id="asistio" name="asistencia" value="2" class="asistencia-checkbox" >No

                            </div>
                        </div>
                    </div>

                    <div class="campo">
                        <label for="fechaHora">Fecha y Hora de Entrada:</label>
                        <input type="datetime-local" id="fechaHora" name="fechaHora" required>
                    </div>
                        <div class="campo">
                            <label for="fechaHoraSalida">Fecha y Hora de Salida:</label>
                            <input type="datetime-local" id="fechaHoraSalida" name="fechaHoraSalida" required>
                        </div>
                    <div class="campo">
                        <button type="submit">Guardar</button>
                    </div>
                </form>
            </div>


                     <?php
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

                    // Cierra la conexión
                    $conn->close();
                } else {
                    $nombres = array();
                }

                ?>
            <div id="formulario2" style="display: none;">
                <form id="form2" class="attendance-form" action="guardar_asistencia_grupal.php" method="post">
                    <div class="campo">
                        <label for="fechaHora2">Fecha y Hora:</label>
                        <input type="datetime-local" id="fechaHora2" name="fechaHora" required>
                    </div>
                    <div class="campo">
                            <label for="fechaHoraSalida2">Fecha y Hora de Salida:</label>
                            <input type="datetime-local" id="fechaHoraSalida" name="fechaHoraSalida" required>
                        </div>

                    <div class="usuarios-container">
                        <?php
                        // Crea elementos para cada usuario
                        foreach ($nombres as $nombre) {
                            echo '<div class="campo">';
                            echo '<label style="width: 100%; display: block;background-color: #ddd; color: #000; font-size: 16px; margin-bottom: 5px;padding:3px">' . $nombre . ':</label>';
                            echo '<div class="asistencia-checkboxes">';
                            echo '<div class="checkbox-container" id="asis"><input type="radio" id="si_' . $nombre . '" name="asistencia_' . $nombre . '" value="1" > Si</div>';
                            echo '<div class="checkbox-container" id="noasis"><input type="radio" id="no_' . $nombre . '" name="asistencia_' . $nombre . '" value="2"> No</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                    </div>

                    <div class="campo" >
                        <button type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </section>



        <!-- Contenedor para Asistencia -->
        <section class="content" id="asistencia">
            <h2>Asistencia de Hoy</h2>

            <!-- Tabla para mostrar los datos del día actual -->
            <table id="tablaAsistencia" border="1" >
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha y Hora de Asistencia</th>
                        <th>Fecha y Hora de Salida</th>
                        <th>Estado de Asistencia</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se cargarán los datos automáticamente con PHP -->
                    <?php include('obtener_asistencias.php'); ?>
                </tbody>
            </table>
        </section>

        <section class="content" id="reporte">
            <p>Contenido de Reporte semanal.</p>
            <a href="generar_reporte.php" target="_blank" style="background-color: #19418D;">Generar y descargar el Reporte Semanal en PDF</a>
        </section>

    </div>

    <script src="script1.js"></script>
    <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const checkboxes = document.querySelectorAll('.asistencia-checkbox');

                    checkboxes.forEach(function (checkbox) {
                        checkbox.addEventListener('change', function () {
                            checkboxes.forEach(function (otherCheckbox) {
                                if (otherCheckbox !== checkbox) {
                                    otherCheckbox.checked = false;
                                }
                            });
                        });
                    });
                });
    </script>
    
    <!-- Agrega este código al final de tu formulario HTML -->


</body>
</html>
