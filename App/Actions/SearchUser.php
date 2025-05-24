<?php
require_once '../Core/Autoload.php';
use App\Models\User;


$searchTerm = $_POST['searchInput'] ?? '';


$users = User::search($searchTerm); 

$users = array_map(function($user) {
    return (array)$user;
}, $users);

require __DIR__ . '/../Views/IndexView.php';