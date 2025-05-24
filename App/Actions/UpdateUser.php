<?php
require_once __DIR__ . '/../Core/Autoload.php';
use App\Models\User;

$userId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');

$errors = [];
if (empty($name)) $errors[] = 'El nombre es requerido';
if (empty($email)) $errors[] = 'El email es requerido';
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'El email no es válido';

if (!empty($errors)) {
    session_start();
    $_SESSION['form_errors'] = $errors;
    $_SESSION['old_input'] = compact('name', 'email');
    header("Location: ../index.php?edit=$userId");
    exit();
}

try {
    
    $user = new User();
    $user->id = $userId;
    $user->name = $name;
    $user->email = $email;
    
    if ($user->save()) {
        header('Location: ../index.php?update_success=1');
    } else {
        throw new Exception('No se pudo actualizar el usuario');
    }
    exit();
    
} catch (Exception $e) {
    error_log('Error al actualizar usuario: ' . $e->getMessage());
    session_start();
    $_SESSION['form_error'] = $e->getMessage();
    $_SESSION['old_input'] = compact('name', 'email');
    header("Location: ../index.php?edit=$userId");
    exit();
}