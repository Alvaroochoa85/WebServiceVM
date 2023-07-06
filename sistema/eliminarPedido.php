<?php
include "../conexion.php";
// Verificar si se ha enviado el formulario de eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pedido'])) {
    
    
    // Obtener el ID del pedido a eliminar
    $id_pedido = $_POST['id_pedido'];
    
    // Realizar la eliminación del pedido en la base de datos
    $query = "DELETE FROM Pedido WHERE id_pedido = $id_pedido";
    $resultado = mysqli_query($conexion, $query);
    
    if ($resultado) {
        echo '<div class="alert alert-success">Pedido eliminado correctamente.</div>';
    } else {
        echo '<div class="alert alert-danger">Error al eliminar el pedido.</div>';
    }
}

// Obtener el ID del pedido a eliminar desde la URL
if (isset($_GET['id'])) {
    $id_pedido = $_GET['id'];
    
    // Realizar la consulta para obtener los datos del pedido
    $query = "SELECT * FROM Pedido WHERE id_pedido = $id_pedido";
    $resultado = mysqli_query($conexion, $query);
    
    // Verificar si se encontró el pedido
    if (mysqli_num_rows($resultado) > 0) {
        $pedido = mysqli_fetch_assoc($resultado);
    } else {
        // Redirigir si el pedido no existe
        header('Location: listaPedido.php');
        exit();
    }
} else {
    // Redirigir si no se proporcionó el ID del pedido
    header('Location: listaPedido.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Eliminar Pedido</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="container">
            <h1>Eliminar Pedido</h1>
            
            <div class="alert alert-danger">
                ¿Estás seguro de que deseas eliminar el siguiente pedido?
            </div>
            <form action="" method="POST">
                <div class="form-group">
                    <label>ID Pedido</label>
                    <input type="text" name="id_pedido" class="form-control" value="<?php echo $pedido['id_pedido']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Observación</label>
                    <textarea class="form-control" readonly><?php echo $pedido['observacion']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Descripción de la Falla</label>
                    <textarea class="form-control" readonly><?php echo $pedido['desc_falla']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Fecha de Pedido</label>
                    <input type="text" class="form-control" value="<?php echo $pedido['fecha']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>ID Cliente</label>
                    <input type="text" class="form-control" value="<?php echo $pedido['id_cliente']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Estado</label>
                    <input type="text" class="form-control" value="<?php echo $pedido['estado']; ?>" readonly>
                </div>
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a href="listaPedido.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>

</body>
</html>                