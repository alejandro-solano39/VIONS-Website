<?php
// Incluir configuración y funciones necesarias
include_once('../actions/get-users.php');  // función para obtener los usuarios
include('../auth/session_check.php');

$usuarios = obtenerUsuarios(); // Llama a la función para obtener los datos
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Lista de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="js/scripts.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>

</head>

<body class="sb-nav-fixed">

    <?php include('includes/navbar.php'); ?>

    <div id="layoutSidenav">
        <?php include('includes/sidenav.php'); ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Lista de Usuarios</h1>

                    <!-- Botón para agregar un nuevo usuario -->
                    <div class="mb-3">
                        <a href="form-user.php" class="btn btn-success">Agregar Nuevo Usuario</a>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Tabla de Usuarios
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Foto de Perfil</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Último Acceso</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Foto de Perfil</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Último Acceso</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php if (!empty($usuarios)): ?>
                                        <?php foreach ($usuarios as $usuario): ?>
                                            <tr>
                                                <td>
                                                    <?php if (!empty($usuario['profile_picture'])): ?>
                                                        <img src="../<?php echo htmlspecialchars($usuario['profile_picture']); ?>" alt="Foto de Perfil" width="50">
                                                    <?php else: ?>
                                                        Sin foto
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($usuario['first_name']) . ' ' . htmlspecialchars($usuario['last_name']); ?></td>
                                                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                                <td><?php echo htmlspecialchars($usuario['role_id']); ?></td>
                                                <td><?php echo htmlspecialchars($usuario['status']);  ?></td>
                                                <td>
                                                    <?php
                                                    echo htmlspecialchars(date('d/m/Y H:i:s', strtotime($usuario['last_login'])));
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="form-user.php?id=<?php echo $usuario['id']; ?>" class="btn btn-primary">Editar</a>
                                                    <button class="btn btn-danger delete-btn" data-id="<?php echo $usuario['id']; ?>">Eliminar</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7">No se encontraron usuarios.</td>
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                const idToDelete = $(this).data('id');
                const rowToDelete = $(this).closest('tr');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '../actions/delete-user.php',
                            type: 'POST',
                            data: {
                                id: idToDelete
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    rowToDelete.remove();
                                    Swal.fire(
                                        'Eliminado',
                                        'El usuario ha sido eliminado.',
                                        'success'
                                    );
                                } else {
                                    Swal.fire(
                                        'Error',
                                        response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error',
                                    'Hubo un problema al procesar la solicitud.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>