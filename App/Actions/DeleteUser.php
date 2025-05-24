<?php
require_once __DIR__ . '/../Core/Autoload.php';
use App\Models\User;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}


$userId = $_POST['id'] ?? null;
if (!$userId || !is_numeric($userId)) {
    http_response_code(400);
    exit('ID de usuario no válido');
}

try {
    $user = new User();
    $user->id = (int)$userId;
    
    if ($user->delete()) {
        header('Location: ../index.php?delete_success=1');
    } else {
        header('Location: ../index.php?delete_error=1');
    }
    exit();
    
} catch (Exception $e) {
    error_log('Error al eliminar usuario: ' . $e->getMessage());
    header('Location: ../index.php?delete_error=1&message=' . urlencode($e->getMessage()));
    exit();
}