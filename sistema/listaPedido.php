<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Lista de Pedidos</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="container">
            <h1>Lista de Pedidos</h1>
            
            <!-- Formulario de búsqueda -->
            <form action="" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_inicio">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_fin">Fecha de Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre">Nombre de Cliente</label>
                            <input type="text" name="nombre" id="nombre" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="dni">DNI de Cliente</label>
                            <input type="text" name="dni" id="dni" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="">Todos los estados</option>
                                <option value="abierto">Abierto</option>
                                <option value="verificado">Verificado</option>
                                <option value="en_reparacion">En Reparación</option>
                                <option value="demorado">Demorado</option>
                                <option value="no_reparado">No Reparado</option>
                                <option value="reparado">Reparado</option>
                                <option value="despachado">Despachado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
            
            <!-- Tabla de pedidos -->
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Observación</th>
                        <th>Descripción de la Falla</th>
                        <th>Fecha de Pedido</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "../conexion.php";
                    
                    // Obtener los parámetros de búsqueda
                    $fecha_inicio = $_GET['fecha_inicio'] ?? '';
                    $fecha_fin = $_GET['fecha_fin'] ?? '';
                    $nombre = $_GET['nombre'] ?? '';
                    $dni = $_GET['dni'] ?? '';
                    $estado = $_GET['estado'] ?? '';
                    
                    // Construir la consulta SQL
                    $query = "SELECT Pedido.id_pedido, Pedido.observacion, Pedido.desc_falla, Pedido.fecha, Cliente.nombre AS cliente_nombre, Pedido.estado FROM Pedido INNER JOIN Cliente ON Pedido.id_cliente = Cliente.id_cliente WHERE 1";
                    
                    if (!empty($fecha_inicio) && !empty($fecha_fin)) {
                        $query .= " AND Pedido.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
                    }
                    
                    if (!empty($nombre)) {
                        $query .= " AND Cliente.nombre LIKE '%$nombre%'";
                    }
                    
                    if (!empty($dni)) {
                        $query .= " AND Cliente.dni = '$dni'";
                    }
                    
                    if (!empty($estado)) {
                        $query .= " AND Pedido.estado = '$estado'";
                    }
                    
                    $resultado = mysqli_query($conexion, $query);

                    while($row = mysqli_fetch_assoc($resultado)){
                        ?>
                        <tr>
                            <td><?php echo $row['id_pedido']; ?></td>
                            <td><?php echo $row['observacion']; ?></td>
                            <td><?php echo $row['desc_falla']; ?></td>
                            <td><?php echo $row['fecha']; ?></td>
                            <td><?php echo $row['cliente_nombre']; ?></td>
                            <td><?php echo $row['estado']; ?></td>
                            <td>
                                <a href="editarPedido.php?id=<?php echo $row['id_pedido']; ?>" class="btn btn-primary">Editar</a>
                                <a href="eliminarPedido.php?id=<?php echo $row['id_pedido']; ?>" class="btn btn-danger">Eliminar</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>
</body>
</html>
