<?php
session_start();

include "../conexion.php";

// autoload.inc.php Verifica si el administrador ha iniciado sesión
if (isset($_SESSION['admin'])) {
    $adminId = $_SESSION['admin'];
} else {
    $adminId = 0;
}

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['observacion']) && isset($_POST['desc_falla']) && isset($_POST['fecha']) && isset($_POST['nombre_cliente']) && isset($_POST['estado'])) {
        $observacion = $_POST['observacion'];
        $desc_falla = $_POST['desc_falla'];
        $fecha = $_POST['fecha'];
        $nombre_cliente = $_POST['nombre_cliente'];
        $estado = $_POST['estado'];

        // Obtener el ID del cliente basado en el nombre
        $query_cliente = "SELECT id_cliente FROM cliente WHERE nombre = '$nombre_cliente'";
        $resultado_cliente = mysqli_query($conexion, $query_cliente);
        $row_cliente = mysqli_fetch_assoc($resultado_cliente);
        $id_cliente = $row_cliente['id_cliente'];

        // Realizar el registro del pedido en la base de datos
        $query = "INSERT INTO pedido (observacion, desc_falla, fecha, id_cliente, estado, id_administrador) VALUES ('$observacion', '$desc_falla', '$fecha', '$id_cliente', '$estado', $adminId)";
        $resultado = mysqli_query($conexion, $query);

        if ($resultado) {
            echo '<div class="alert alert-success">Pedido registrado correctamente.</div>';
        } else {
            echo '<div class="alert alert-danger">Error al registrar el pedido: ' . mysqli_error($conexion) . '</div>';
        }
        // Redireccionar a listaPedido.php
        header("Location: listaPedido.php");
        exit();
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Registro de Pedidos</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="container">
            <h1>Registro de Pedidos</h1>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="observacion">Observación</label>
                    <textarea name="observacion" id="observacion" class="form-control" rows="1" required></textarea>
                </div>
                <div class="form-group">
                    <label for="desc_falla">Descripción de la Falla</label>
                    <textarea name="desc_falla" id="desc_falla" class="form-control" rows="1" required></textarea>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="nombre_cliente">Nombre del cliente</label>
                    <select name="nombre_cliente" id="nombre_cliente" class="form-control" required>
                        <?php
                        // Obtener los nombres de los clientes
                        $query_clientes = "SELECT nombre FROM cliente";
                        $resultado_clientes = mysqli_query($conexion, $query_clientes);
                        while ($row_cliente = mysqli_fetch_assoc($resultado_clientes)) {
                            echo '<option value="' . $row_cliente['nombre'] . '">' . $row_cliente['nombre'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control" required>
                        <option value="abierto">Abierto</option>
                        <option value="verificado">Verificado</option>
                        <option value="en_reparacion">En Reparación</option>
                        <option value="demorado">Demorado</option>
                        <option value="no_reparado">No Reparado</option>
                        <option value="reparado">Reparado</option>
                        <option value="despachado">Despachado</option>
                    </select>
                </div>
                <?php
                // Verificar si el administrador ha iniciado sesión
                if (isset($_SESSION['admin'])) {
                    echo '<div class="form-group">
                            <label for="admin">Administrador</label>
                            <input type="text" name="admin" id="admin" class="form-control" required>
                          </div>';
                }
                ?>
                <input type="submit" value="Registrar Pedido" class="btn btn-primary">
            </form>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>
</body>
</html>
