<?php
include('../../config/config.php');
include_once('../../actions/get-all-DJs.php');

session_start();

$response = ['success' => false, 'message' => 'Solicitud no válida.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    if ($id <= 0) {
        $response['message'] = 'ID no válido.';
        echo json_encode($response);
        exit;
    }

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        $response['message'] = 'Error en la conexión con la base de datos.';
        echo json_encode($response);
        exit;
    }

    // Obtener el estado actual del portafolio
    $query = "SELECT activo FROM djs_portfolios WHERE id = ?"; // Cambié 'portfolios' por 'djs_portfolios'
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nuevoEstado = $row['activo'] ? 0 : 1;

            // Actualizar el estado del portafolio
            $updateQuery = "UPDATE djs_portfolios SET activo = ? WHERE id = ?"; // Cambié 'portfolios' por 'djs_portfolios'
            $updateStmt = $conn->prepare($updateQuery);

            if ($updateStmt) {
                $updateStmt->bind_param('ii', $nuevoEstado, $id);

                if ($updateStmt->execute()) {
                    $response = [
                        'success' => true,
                        'message' => $nuevoEstado ? 'Portafolio activado con éxito.' : 'Portafolio desactivado con éxito.',
                        'new_status' => $nuevoEstado
                    ];
                } else {
                    $response['message'] = 'Error al actualizar el estado del portafolio.';
                }

                $updateStmt->close();
            } else {
                $response['message'] = 'Error al preparar la consulta de actualización.';
            }
        } else {
            $response['message'] = 'Portafolio no encontrado.';
        }

        $stmt->close();
    } else {
        $response['message'] = 'Error al preparar la consulta.';
    }

    $conn->close();
} else {
    $response['message'] = 'Solicitud no válida o datos incompletos.';
}

echo json_encode($response);
?>
