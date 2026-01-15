<?php
include_once('../../config/config.php');

// Función para obtener todos los usuarios
function obtenerUsuarios()
{
    global $pdo;

    try {
        $sql = "SELECT 
                    u.id, u.first_name, u.last_name, u.email, u.role_id, u.status, u.last_login, u.profile_picture, r.role_name 
                FROM users u
                LEFT JOIN roles r ON u.role_id = r.id
                ORDER BY u.first_name ASC";

        $stmt = $pdo->prepare($sql);

        $stmt->execute();

        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $usuarios;
    } catch (PDOException $e) {
        error_log("Error en la base de datos: " . $e->getMessage());
        return [];
    }
}
