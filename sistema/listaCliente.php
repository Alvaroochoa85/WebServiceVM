<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Lista de Clientes</title>

</head>
<body>
    <?php include "includes/header.php"; ?>
    <div class="container">
    <h1>Lista de Clientes</h1>
    <form action="" method="GET" class="mt-5">
        <div class="row ">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="busqueda" placeholder="Buscar por DNI, Teléfono o Nombre" value="<?php echo isset($_GET['busqueda']) ? $_GET['busqueda'] : ''; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="listaCliente.php" class="btn btn-secondary">Limpiar</a>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../conexion.php";
            
            // Obtener el término de búsqueda
            $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

            // Construir la consulta
            $query = "SELECT * FROM Cliente WHERE dni LIKE '%$busqueda%' OR telefono LIKE '%$busqueda%' OR nombre LIKE '%$busqueda%'";
            $resultado = mysqli_query($conexion, $query);

            while($row = mysqli_fetch_assoc($resultado)){
                ?>
                <tr>
                    <td><?php echo $row['dni']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['telefono']; ?></td>
                    <td><?php echo $row['direccion']; ?></td>
                    <td>
                        <a href="editarCliente.php?id=<?php echo $row['id_cliente']; ?>" class="btn btn-primary">Editar</a>
                        <a href="eliminarCliente.php?id=<?php echo $row['id_cliente']; ?>" class="btn btn-danger">Eliminar</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
