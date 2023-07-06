<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Eliminar Usuario</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="container">
            <h1>Eliminar Usuario</h1>
            <?php
            include "../conexion.php";
            
            // Obtengo el ID del usuario a eliminar
            $id_usuario = $_GET['id'];
            
            // Verificar si el formulario ha sido enviado
            if(isset($_POST['eliminar'])){
                // Eliminar el usuario de la base de datos
                $query = "DELETE FROM Usuario WHERE id_usuario = $id_usuario";
                $resultado = mysqli_query($conexion, $query);

                if($resultado){
                    header("Location: listaUsuario.php");
                }else{
                    echo "<div class='alert alert-danger'>Error al eliminar el usuario</div>";
                }
            }
            ?>
            <p>¿Estás seguro quieres eliminar este usuario?</p>
            <form action="" method="POST">
                <button type="submit" class="btn btn-danger" name="eliminar">Eliminar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>

</body>
</html>
