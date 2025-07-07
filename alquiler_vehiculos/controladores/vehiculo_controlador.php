<?php
require_once __DIR__ . '/../modelos/vehiculo_modelo.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['placa'])) {
        $vehiculo = VehiculoModelo::obtenerPorPlaca($_GET['placa']);
        if ($vehiculo) {
            header('Content-Type: application/json');
            echo json_encode($vehiculo);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Vehículo no encontrado']);
        }
        exit;
    } else {
        $vehiculos = VehiculoModelo::obtenerTodos();
        header('Content-Type: application/json');
        echo json_encode($vehiculos);
        exit;
    }
}
// Puedes agregar aquí POST, PUT, DELETE según necesidades futuras. 