<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php" ;?>
    <title>Web Service V0.1</title>
    <!-- Agregar enlace al archivo CSS de Bootstrap -->
    
</head>
<body>
    <?php include "includes/header.php";?>
    <section id="container">
	<div class="container">
    <h1>Lista de Usuarios</h1>
    <form action="" method="GET" class="mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="busqueda" placeholder="Buscar por Nombre, Email o Usuario" value="<?php echo isset($_GET['busqueda']) ? $_GET['busqueda'] : ''; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="listaUsuario.php" class="btn btn-secondary">Limpiar</a>
            </div>
        </div>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../conexion.php";

            // Obtener el valor de búsqueda
            $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

            // Consulta SQL para buscar usuarios
            $query = "SELECT u.*, r.rol FROM Usuario u
                      INNER JOIN Rol r ON u.rol = r.id_rol
                      WHERE u.nombre LIKE '%$busqueda%' OR u.email LIKE '%$busqueda%' OR u.usuario LIKE '%$busqueda%'";
            $resultado = mysqli_query($conexion, $query);

            while ($row = mysqli_fetch_assoc($resultado)) {
                ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['usuario']; ?></td>
                    <td><?php echo $row['rol']; ?></td>
                    <td>
                        <a href="editarUsuario.php?id=<?php echo $row['id_usuario']; ?>" class="btn btn-primary">Editar</a>
                        <a href="eliminarUsuario.php?id=<?php echo $row['id_usuario']; ?>" class="btn btn-danger">Eliminar</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>

    </section>

    <?php include "includes/footer.php";?>

    <!-- Agregar enlace al archivo JS de Bootstrap -->
    
</body>
</html>
