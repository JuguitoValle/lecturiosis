<?php

require_once '../Core/Autoload.php';
use App\Models\User;

$userId=$_POST['searchInput'];

$user =new User();
$users =$user->findById($userId);
$users = [
    
    (array)

$users

];

require __DIR__ . './../Views/IndexView.php';