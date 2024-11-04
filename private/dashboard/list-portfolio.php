<?php
include_once('../../actions/get-category.php');
include_once('../../actions/get-all-portfolios.php');

$artistas = obtenerArtistas(); // Llama a la función para obtener los datos
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

    <?php include('includes/navbar.php'); ?>

    <div id="layoutSidenav">
        <?php include('includes/sidenav.php'); ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Lista de portafolios</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Example
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Profile Image</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Category</th>
                                        <th>Contact</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Profile Image</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Category</th>
                                        <th>Contact</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php if (!empty($artistas)): ?>
                                        <?php foreach ($artistas as $artista): ?>
                                            <tr>
                                            <td>
    <?php if (!empty($artista['miniatura'])): ?>
        <?php
            // Asegúrate de que la ruta de la miniatura sea absoluta desde la raíz
            $miniaturaURL = "/uploads/" . htmlspecialchars($artista['miniatura']);
        ?>
        <img src="<?php echo $miniaturaURL; ?>" alt="Miniatura" width="50">
    <?php else: ?>
        Sin miniatura
    <?php endif; ?>
</td>

                                                <td><?php echo htmlspecialchars($artista['nombre']); ?></td>
                                                <td><?php echo htmlspecialchars($artista['rol']); ?></td>
                                                <td><?php echo htmlspecialchars($artista['categoria_id']); ?></td>
                                                <td><?php echo htmlspecialchars($artista['contacto']); ?></td>
                                                <td>
                                                    <!-- Aquí podrías agregar acciones como botones de edición o eliminación -->
                                                    <button class="btn btn-primary">Editar</button>
                                                    <button class="btn btn-danger">Eliminar</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6">No se encontraron artistas.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>
