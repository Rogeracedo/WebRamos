<?php
include_once("../../models/Conexion.php");
session_start();
if (!isset($_SESSION["rol"]) ||  $_SESSION["rol"] != "Admin") {
    header("Location: ../landing/index.php");
}

$cn = new Conexion();
$con = $cn->getConnection();

try {
    $dataRespuesta = array();
    $query = "SELECT * from proyecto ;";
    $result = mysqli_query($con, $query);
    if (!$result) {
        throw new Exception('Error en la consulta: ' . mysqli_error($con));
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $dataRespuesta[] = array(
            'id' => $row["idproyecto"],
            'nombre' => $row["nombre"],
            'fin' => $row["fechaFin"],
            'inicio' => $row["fechaInicio"]
        );
    }
} catch (Exception $e) {
    return null;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario - Panel de Administración</title>
    <link rel="stylesheet" href="../../estilos/estilosadmin/styles.css">
    <link rel="stylesheet" href="../../estilos/estilosadmin/calendario.css">
</head>

<body>
    <?php include_once("../plantilla/navbar-asesor.php") ?>
    <div class="content">
        <header>
            <h1>Calendario de Actividades</h1>
        </header>
        <section id="calendar">
            <div id="calendar-header">
                <button id="prev-month">◀</button>
                <h2 id="month-year"></h2>
                <button id="next-month">▶</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miércoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sábado</th>
                        <th>Domingo</th>
                    </tr>
                </thead>
                <tbody id="calendar-body">
                    <!-- Dinámico -->
                </tbody>
            </table>
        </section>
    </div>
    <script>
        function abrirDetalle(id) {
            window.location.href = `detalle.php?proyecto=${id}`;
        }

        document.addEventListener("DOMContentLoaded", () => {
            const calendarBody = document.getElementById("calendar-body");
            const monthYear = document.getElementById("month-year");
            const prevMonth = document.getElementById("prev-month");
            const nextMonth = document.getElementById("next-month");

            let currentDate = new Date();
            let eventos = [];
            let inicio = ";"
            let fin = "";

            let evento = {};
            <?php foreach ($dataRespuesta as $variable): ?>
                evento = {
                    id: <?php echo json_encode($variable["id"]); ?>,
                    nombre: <?php echo json_encode($variable["nombre"]); ?>,
                    fechainicio: new Date("<?php echo $variable['inicio']; ?>"),
                    fechafin: new Date("<?php echo $variable['fin']; ?>")
                };

                evento.fechainicio.setHours(evento.fechainicio.getHours() + 5);
                evento.fechafin.setHours(evento.fechafin.getHours() + 5);

                eventos.push(evento);
            <?php endforeach; ?>

            // Verifica que las variables estén correctamente llenas
            console.log(eventos);

            const renderCalendar = (date) => {
                calendarBody.innerHTML = "";

                const firstDay = new Date(date.getFullYear(), date.getMonth(), 1).getDay();
                const daysInMonth = new Date(
                    date.getFullYear(),
                    date.getMonth() + 1,
                    0
                ).getDate();
                const monthNames = [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre",
                ];

                monthYear.textContent = `${
      monthNames[date.getMonth()]
    } ${date.getFullYear()}`;

                let day = 1;
                for (let i = 0; i < 6; i++) {
                    const row = document.createElement("tr");

                    for (let j = 0; j < 7; j++) {
                        const cell = document.createElement("td");

                        if ((i === 0 && j < (firstDay || 7) - 1) || day > daysInMonth) {
                            cell.textContent = "";
                        } else {
                            cell.textContent = day;
                            for (let evento of eventos) {
                                if (evento.fechainicio.getDate() == day && evento.fechainicio.getMonth() == currentDate.getMonth() &&
                                    evento.fechainicio.getFullYear() === date.getFullYear()) { // Asegúrate de que también coincida el mes
                                    let dia = day;
                                    if (!cell.innerHTML.includes(dia)) {
                                        cell.innerHTML = dia + `<br>`;
                                    }

                                    // Crear el div para el evento
                                    let divEvento = document.createElement('div');
                                    divEvento.innerHTML = `${evento.nombre}`;

                                    // Estilos para el div
                                    divEvento.style.backgroundColor = 'blue';
                                    divEvento.style.color = 'white';
                                    divEvento.style.padding = '5px';
                                    divEvento.style.borderRadius = '10px';
                                    divEvento.style.marginTop = '5px';
                                    divEvento.style.cursor = 'pointer';

                                    // Asociar el evento con el id correspondiente
                                    divEvento.addEventListener("click", () => {
                                        abrirDetalle(evento.id); // Usar el id correspondiente
                                    });

                                    // Añadir el div a la celda
                                    cell.appendChild(divEvento);

                                }
                            }
                            day++;
                        }
                        row.appendChild(cell);
                    }

                    calendarBody.appendChild(row);
                }
            };

            prevMonth.addEventListener("click", () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar(currentDate);
            });

            nextMonth.addEventListener("click", () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar(currentDate);
            });

            renderCalendar(currentDate);
        });
    </script>
</body>

</html>