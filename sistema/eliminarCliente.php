<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Eliminar Cliente</title>

</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="container">
            <h1>Eliminar Cliente</h1>
            <?php
            include "../conexion.php";
            
            // Obtener el ID del cliente a eliminar
            $id_cliente = $_GET['id'];
            
            // Verificar si el formulario ha sido enviado
            if(isset($_POST['eliminar'])){
                // Eliminar el cliente de la base de datos
                $query = "DELETE FROM Cliente WHERE id_cliente = $id_cliente";
                $resultado = mysqli_query($conexion, $query);

                if($resultado){
                    header("Location: listaCliente.php");
                }else{
                    echo "<div class='alert alert-danger'>Error al eliminar el cliente</div>";
                }
            }
            ?>
            <p>¿Estás seguro de que deseas eliminar este cliente?</p>
            <form action="" method="POST">
                <button type="submit" class="btn btn-danger" name="eliminar">Eliminar</button>
                <a href="listaCliente.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>

</body>
</html>

