<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Registro de Clientes</title>
  
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="container">
            <h1>Registro de Clientes</h1>
            <?php
            include "../conexion.php";

            if(isset($_POST['guardar'])){
                $dni = $_POST['dni'];
                $nombre = $_POST['nombre'];
                $telefono = $_POST['telefono'];
                $direccion = $_POST['direccion'];

                // Insertar los datos del cliente en la base de datos
                $query = "INSERT INTO Cliente (dni, nombre, telefono, direccion) VALUES ('$dni', '$nombre', '$telefono', '$direccion')";
                $resultado = mysqli_query($conexion, $query);

                if($resultado){
                    header("Location: listaCliente.php");
                }else{
                    echo "<div class='alert alert-danger'>Error al registrar el cliente</div>";
                }
            }
            ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" class="form-control" id="dni" name="dni" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                </div>
                <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
            </form>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>

</body>
</html>
