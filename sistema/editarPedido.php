<?php
include "../conexion.php";

// Obtener el ID del pedido a editar
$idPedido = $_GET['id'];

// Verificar si se ha enviado el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los nuevos datos del pedido
    $observacion = $_POST['observacion'];
    $descFalla = $_POST['desc_falla'];
    $fecha = $_POST['fecha'];
    $idCliente = $_POST['id_cliente'];
    $estado = $_POST['estado'];

    // Actualizar los datos del pedido en la base de datos
    $query = "UPDATE Pedido SET observacion = '$observacion', desc_falla = '$descFalla', fecha = '$fecha', id_cliente = '$idCliente', estado = '$estado' WHERE id_pedido = $idPedido";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo '<div class="alert alert-success">Pedido actualizado correctamente.</div>';
    } else {
        echo '<div class="alert alert-danger">Error al actualizar el pedido.</div>';
    }
}

// Obtener los datos del pedido a editar
$queryPedido = "SELECT * FROM Pedido WHERE id_pedido = $idPedido";
$resultadoPedido = mysqli_query($conexion, $queryPedido);
$pedido = mysqli_fetch_assoc($resultadoPedido);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Editar Pedido</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="container">
            <h1>Editar Pedido</h1>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="observacion">Observación</label>
                    <textarea name="observacion" id="observacion" class="form-control" rows="4" required><?php echo $pedido['observacion']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="desc_falla">Descripción de la Falla</label>
                    <textarea name="desc_falla" id="desc_falla" class="form-control" rows="4" required><?php echo $pedido['desc_falla']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo $pedido['fecha']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="id_cliente">ID Cliente</label>
                    <input type="text" name="id_cliente" id="id_cliente" class="form-control" value="<?php echo $pedido['id_cliente']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control" required>
                        <option value="abierto" <?php if ($pedido['estado'] == 'abierto') echo 'selected'; ?>>Abierto</option>
                        <option value="verificado" <?php if ($pedido['estado'] == 'verificado') echo 'selected'; ?>>Verificado</option>
                        <option value="en_reparacion" <?php if ($pedido['estado'] == 'en_reparacion') echo 'selected'; ?>>En Reparación</option>
                        <option value="demorado" <?php if ($pedido['estado'] == 'demorado') echo 'selected'; ?>>Demorado</option>
                        <option value="no_reparado" <?php if ($pedido['estado'] == 'no_reparado') echo 'selected'; ?>>No Reparado</option>
                        <option value="reparado" <?php if ($pedido['estado'] == 'reparado') echo 'selected'; ?>>Reparado</option>
                        <option value="despachado" <?php if ($pedido['estado'] == 'despachado') echo 'selected'; ?>>Despachado</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </section>
<?php include "includes/footer.php"; ?>
</body>
</html>

