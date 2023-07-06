<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Editar Usuario</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="container">
            <h1>Editar Usuario</h1>
            <?php
            include "../conexion.php";
            
            // Obtenengo el ID del usuario que quiero editar
            $id_usuario = $_GET['id'];
            
            // Consultar los datos del usuario
            $query = "SELECT * FROM Usuario WHERE id_usuario = $id_usuario";
            $resultado = mysqli_query($conexion, $query);
            $row = mysqli_fetch_assoc($resultado);

            // Verificar si el formulario ha sido enviado
            if(isset($_POST['guardar'])){
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
                $usuario = $_POST['usuario'];
                $rol = $_POST['rol'];

                // Actualizar los datos del usuario en la base de datos
                $query = "UPDATE Usuario SET nombre = '$nombre', email = '$email', usuario = '$usuario', rol = '$rol' WHERE id_usuario = $id_usuario";
                $resultado = mysqli_query($conexion, $query);

                if($resultado){
                    header("Location: index.php");
                }else{
                    echo "<div class='alert alert-danger'>Error al actualizar el usuario</div>";
                }
            }
            ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>">
                </div>
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $row['usuario']; ?>">
                </div>
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select class="form-control" id="rol" name="rol">
                        <?php
                        $query_rol = mysqli_query($conexion, "SELECT * FROM Rol");
                        while ($rol = mysqli_fetch_assoc($query_rol)) {
                            if ($rol['id_rol'] == $row['rol']) {
                                echo "<option value='" . $rol['id_rol'] . "' selected>" . $rol['rol'] . "</option>";
                            } else {
                                echo "<option value='" . $rol['id_rol'] . "'>" . $rol['rol'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="guardar">Guardar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>

</body>
</html>
