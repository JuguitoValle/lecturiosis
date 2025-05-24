<?php
require_once __DIR__ . '/../Core/Autoload.php';
use App\Models\User;


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once __DIR__ . '/../Views/Create_User.php';
    exit();
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}


$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');


$errors = [];
if (empty($name)) $errors[] = 'Nombre es requerido';
if (empty($email)) $errors[] = 'Email es requerido';
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email no válido';
if (empty($password)) $errors[] = 'Password es requerido';

if (!empty($errors)) {
    session_start();
    $_SESSION['form_errors'] = $errors;
    $_SESSION['old_input'] = compact('name', 'email', 'password');
    header('Location: ../Views/Create_User.php');
    exit();
}

try {
    
    $user = new User();
    $user->name = $name;
    $user->email = $email;
    $user->password = password_hash($password, PASSWORD_DEFAULT); // Hashear la contraseña
    
    if ($user->save()) {
        header('Location: ../index.php?create_success=1');
    } else {
        throw new Exception('Error al guardar usuario');
    }
    exit();
    
} catch (Exception $e) {
    error_log('Error: ' . $e->getMessage());
    session_start();
    $_SESSION['form_error'] = $e->getMessage();
    $_SESSION['old_input'] = compact('name', 'email', 'password');
    header('Location: ../Views/Create_User.php');
    exit();
}