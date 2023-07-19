<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Editar Cliente</title>

</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="container">
            <h1>Editar Cliente</h1>
            <?php
            include "../conexion.php";

            // Obtener el ID del cliente a editar
            $id_cliente = $_GET['id'];

            // Verificar si el formulario ha sido enviado
            if(isset($_POST['guardar'])){
                $dni = $_POST['dni'];
                $nombre = $_POST['nombre'];
                $telefono = $_POST['telefono'];
                $direccion = $_POST['direccion'];

                // Actualizar los datos del cliente en la base de datos
                $query = "UPDATE Cliente SET dni = '$dni', nombre = '$nombre', telefono = '$telefono', direccion = '$direccion' WHERE id_cliente = $id_cliente";
                $resultado = mysqli_query($conexion, $query);

                if($resultado){
                    header("Location: listaCliente.php");
                }else{
                    echo "<div class='alert alert-danger'>Error al actualizar el cliente</div>";
                }
            }

            // Obtener los datos del cliente de la base de datos
            $query = "SELECT * FROM Cliente WHERE id_cliente = $id_cliente";
            $resultado = mysqli_query($conexion, $query);
            $cliente = mysqli_fetch_assoc($resultado);
            ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $cliente['dni']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $cliente['nombre']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $cliente['telefono']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $cliente['direccion']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
            </form>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>

</body>
</html>
