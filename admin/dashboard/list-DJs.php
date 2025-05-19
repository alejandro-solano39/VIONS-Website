<?php
include_once('../../actions/get-category.php');
include_once('../../actions/get-all-DJs.php');
include('../auth/session_check.php');

if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'El DJ se ha creado correctamente.',
                showConfirmButton: false,
                timer: 2000
            });
        });
    </script>";
}

$djs = obtenerDJs(false); // false para obtener todos los DJs, activos e inactivos
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
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.4/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.4/dist/sweetalert2.min.js"></script>

</head>

<style>
    body {
        background-color: #f8f9fa;
        color: #2c3e50;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h1 {
        color: #2c3e50;
        text-align: center;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        background-color: #2c3e50;
        color: #fff;
        font-weight: 600;
        text-align: center;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        padding: 15px;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead {
        background-color: #2c3e50;
        color: #fff;
    }

    .table thead th {
        font-weight: 600;
        padding: 12px;
    }

    .table tbody tr {
        transition: background-color 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #ecf0f1;
    }

    .table tbody td {
        padding: 12px;
        vertical-align: middle;
    }

    .table tbody td img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
    }

    .btn {
        font-size: 14px;
        padding: 6px 12px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background-color: #3498db;
        border: none;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }

    .btn-danger {
        background-color: #e74c3c;
    }

    .btn-danger:hover {
        background-color: #c0392b;
    }

    .btn-success {
        background-color: #2ecc71;
    }

    .btn-success:hover {
        background-color: #27ae60;
    }

    .btn-secondary {
        background-color: #95a5a6;
    }

    .btn-secondary:hover {
        background-color: #7f8c8d;
    }

    .btn i {
        font-size: 14px;
    }

    .text-muted {
        color: #95a5a6 !important;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        color: #95a5a6;
    }
</style>

<body class="sb-nav-fixed">
    <?php include('includes/navbar.php'); ?>

    <div id="layoutSidenav">
        <?php include('includes/sidenav.php'); ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container my-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
                        <h1>Lista de Portafolios de DJs</h1>
                        <a href="form-DJs.php" class="btn btn-primary btn-lg d-flex align-items-center gap-2">
                            <i class="fas fa-plus"></i>
                            Nuevo Portafolio
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i> Portafolios de DJs
                        </div>
                        <div class="card-body table-responsive">
                            <table id="datatablesSimple" class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Nombre del DJ</th>
                                        <th>Título del Portafolio</th>
                                        <th>Categoría</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($djs)): ?>
                                        <?php foreach ($djs as $dj): ?>
                                            <tr>
                                                <td>
                                                    <?php if (!empty($dj['slider_images'])): ?>
                                                        <img src="../<?php echo htmlspecialchars($dj['imagen_perfil']); ?>" alt="Imagen del DJ">
                                                    <?php else: ?>
                                                        <span class="text-muted">Sin imagen</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($dj['dj_name']); ?></td>
                                                <td><?php echo htmlspecialchars($dj['post_title']); ?></td>
                                                <td><?php echo htmlspecialchars(is_array($dj['categoria_nombres']) ? implode(', ', $dj['categoria_nombres']) : $dj['categoria_nombres']); ?></td>
                                                <td>
                                                    <a href="form-Djs.php?id=<?php echo $dj['id']; ?>" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $dj['id']; ?>" data-type="dj_portfolio">
                                                        <i class="fas fa-trash-alt"></i> Eliminar
                                                    </button>
                                                    <?php if ($dj['activo']): ?>
                                                        <button class="btn btn-success btn-sm toggle-btn" data-id="<?php echo $dj['id']; ?>">
                                                            <i class="fas fa-check-circle"></i> Activo
                                                        </button>
                                                    <?php else: ?>
                                                        <button class="btn btn-secondary btn-sm toggle-btn" data-id="<?php echo $dj['id']; ?>">
                                                            <i class="fas fa-ban"></i> Inactivo
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="no-data">No se encontraron DJs.</td>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Aquí gestionamos el toggle del sidebar para pantallas pequeñas
        document.getElementById("sidebarToggle").addEventListener("click", function() {
            document.getElementById("layoutSidenav").classList.toggle("sb-sidenav-toggled");
        });

        $(document).on('click', '.delete-btn', function() {
            const button = $(this);
            const idToDelete = button.data('id'); // ID del DJ
            const rowToDelete = button.closest('tr'); // Fila a eliminar

            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/actions/delete-djs-portfolio.php', // Asegúrate de que esta ruta sea correcta
                        type: 'POST',
                        data: {
                            id: idToDelete // Enviar la ID para que el PHP la reciba
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                rowToDelete.remove(); // Eliminar la fila de la tabla
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Eliminado',
                                    text: 'El portafolio ha sido eliminado.',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'No se pudo eliminar el portafolio.',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error); // Log el error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un problema con la solicitud.',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    });
                }
            });
        });


        $(document).on('click', '.toggle-btn', function() {
            const button = $(this);
            const id = button.data('id');

            $.ajax({
                url: '/admin/actions/toggle-djs-portfolio.php',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const newStatus = response.new_status;

                        // Cambiar el texto y el ícono según el estado
                        if (newStatus === 1) {
                            button
                                .data('status', 1)
                                .removeClass('btn-secondary')
                                .addClass('btn-success')
                                .html('<i class="fas fa-check-circle"></i> Activo');
                        } else {
                            button
                                .data('status', 0)
                                .removeClass('btn-success')
                                .addClass('btn-secondary')
                                .html('<i class="fas fa-ban"></i> Inactivo');
                        }

                        // Mostrar notificación de éxito con SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'Estado Actualizado',
                            text: 'El estado del portafolio ha sido actualizado correctamente.',
                            showConfirmButton: false,
                            timer: 2000 // Cierra automáticamente después de 2 segundos
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Hubo un problema al actualizar el estado.',
                            showConfirmButton: false,
                            timer: 2000 // Cierra automáticamente después de 2 segundos
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al intentar actualizar el estado.',
                        showConfirmButton: false,
                        timer: 2000 // Cierra automáticamente después de 2 segundos
                    });
                }
            });
        });
    </script>
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'El DJ se ha guardado correctamente',
                confirmButtonText: 'Aceptar'
            });

            // Eliminar el parámetro ?success=1 de la URL sin recargar
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('success');
                window.history.replaceState(null, '', url);
            }
        </script>
    <?php endif; ?>

</body>

</html>