<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Web Service V0.1</title>
    <!-- Agregar el enlace al archivo de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <h1>Bienvenido a Web Service VM</h1>

        <!-- Agregar un formulario de búsqueda -->
        <form action="" method="GET">
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
            </div>
            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <?php
		include "../conexion.php";
        // Obtener la cantidad de clientes
        $query_clientes = "SELECT COUNT(*) AS cantidad_clientes FROM cliente";
        $resultado_clientes = mysqli_query($conexion, $query_clientes);
        $cantidad_clientes = mysqli_fetch_assoc($resultado_clientes)['cantidad_clientes'];

        // Obtener la cantidad de pedidos
        $query_pedidos = "SELECT COUNT(*) AS cantidad_pedidos FROM pedido";
        $resultado_pedidos = mysqli_query($conexion, $query_pedidos);
        $cantidad_pedidos = mysqli_fetch_assoc($resultado_pedidos)['cantidad_pedidos'];

        // Obtener la cantidad de pedidos y clientes por fecha
        $fecha_inicio = $_GET['fecha_inicio'] ?? null;
        $fecha_fin = $_GET['fecha_fin'] ?? null;
        $labels = [];
        $data_pedidos = [];
        $data_clientes = [];

        if ($fecha_inicio && $fecha_fin) {
            $query_pedidos_fecha = "SELECT fecha, COUNT(*) AS cantidad_pedidos_fecha FROM pedido WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' GROUP BY fecha";
            $resultado_pedidos_fecha = mysqli_query($conexion, $query_pedidos_fecha);

            while ($row_pedidos_fecha = mysqli_fetch_assoc($resultado_pedidos_fecha)) {
                $labels[] = $row_pedidos_fecha['fecha'];
                $data_pedidos[] = $row_pedidos_fecha['cantidad_pedidos_fecha'];
            }

            $query_clientes_fecha = "SELECT fecha, COUNT(DISTINCT id_cliente) AS cantidad_clientes_fecha FROM pedido WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin' GROUP BY fecha";
            $resultado_clientes_fecha = mysqli_query($conexion, $query_clientes_fecha);

            while ($row_clientes_fecha = mysqli_fetch_assoc($resultado_clientes_fecha)) {
                $data_clientes[] = $row_clientes_fecha['cantidad_clientes_fecha'];
            }
        }
        ?>

        <!-- Mostrar los datos estadísticos -->
        <p>Cantidad de clientes: <?php echo $cantidad_clientes; ?></p>
        <p>Cantidad de pedidos: <?php echo $cantidad_pedidos; ?></p>

        <?php if ($fecha_inicio && $fecha_fin): ?>
            <h2>Estadísticas por Fecha</h2>
            <p>Rango de fechas: <?php echo $fecha_inicio; ?> - <?php echo $fecha_fin; ?></p>
            <p>Cantidad de pedidos por fecha:</p>
            <canvas id="graficoPedidosFecha"></canvas>
            <p>Cantidad de clientes por fecha:</p>
            <canvas id="graficoClientesFecha"></canvas>

            <script>
                // Crear gráfico de pedidos por fecha
                var ctxPedidosFecha = document.getElementById('graficoPedidosFecha').getContext('2d');
                var graficoPedidosFecha = new Chart(ctxPedidosFecha, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($labels); ?>,
                        datasets: [{
                            label: 'Cantidad de Pedidos',
                            data: <?php echo json_encode($data_pedidos); ?>,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }
                    }
                });

                // Crear gráfico de clientes por fecha
                var ctxClientesFecha = document.getElementById('graficoClientesFecha').getContext('2d');
                var graficoClientesFecha = new Chart(ctxClientesFecha, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($labels); ?>,
                        datasets: [{
                            label: 'Cantidad de Clientes',
                            data: <?php echo json_encode($data_clientes); ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }
                    }
                });
            </script>
        <?php endif; ?>

    </section>

    <?php include "includes/footer.php"; ?>
</body>
</html>
