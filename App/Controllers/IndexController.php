<?php
// App/controllers/IndexController.php
require_once __DIR__ . '/../models/ModelInterface.php';
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../models/User.php';

// Configuración para mostrar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>PHP MVC Test</title></head><body>";

// Instancia y uso del modelo User
$user = new User();
$user->setId(1);
$user->setName("Danna Valler");
$user->setEmail("valledanna82@gmail.com");

// Mostrar información del usuario
echo "<h2>Información del Usuario:</h2>";
echo "<p>ID: " . $user->getId() . "</p>";
echo "<p>Nombre: " . $user->getName() . "</p>";
echo "<p>Email: " . $user->getEmail() . "</p>";

// Llamar a los métodos del modelo
echo "<h2>Funciones:</h2>";
$user->save();
$user->findById($user->getId());
$user->delete();

echo "</body></html>";
