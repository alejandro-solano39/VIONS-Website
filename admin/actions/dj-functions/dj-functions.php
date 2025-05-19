<?php
// dj-functions.php

// Incluir la configuración de la base de datos
include_once('../../config/config.php');

/**
 * Obtener todos los DJs (portafolios)
 * @param bool $soloActivos Si es true, solo obtiene DJs activos
 * @return array Lista de DJs
 */
function obtenerDJs($soloActivos = false) { // Cambiado a false para obtener todos los DJs
    global $pdo; // Usamos la conexión PDO definida en config.php

    try {
        $sql = "SELECT * FROM djs_portfolios"; // Consulta para obtener todos los DJs
        if ($soloActivos) {
            $sql .= " WHERE activo = 1"; // Filtra solo los activos si $soloActivos es true
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los DJs como un array asociativo
    } catch (PDOException $e) {
        error_log("Error en obtenerDJs: " . $e->getMessage());
        return []; // Si hay un error, retorna un array vacío
    }
}

/**
 * Obtener el número total de DJs (portafolios)
 * @return int Número total de DJs
 */
function obtenerTotalDJs() {
    global $pdo; // Usamos la conexión PDO definida en config.php

    try {
        $query = "SELECT COUNT(*) as total FROM djs_portfolios"; // Cuenta todos los DJs
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int)$result['total']; // Retorna el número total de DJs
    } catch (PDOException $e) {
        error_log("Error en obtenerTotalDJs: " . $e->getMessage());
        return 0; // Si hay un error, retorna 0
    }
}