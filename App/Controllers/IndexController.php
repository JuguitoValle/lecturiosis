<?php
namespace App\Controllers;

use App\Models\User;

class IndexController
{
    public function __construct()
    {
        $users = User::get();
        
        
        if (isset($_GET['create_success']) && $_GET['create_success'] == 1) {
            $successMessage = 'Usuario creado';
        } elseif (isset($_GET['update_success']) && $_GET['update_success'] == 1) {
            $successMessage = 'Usuario actualizado';
        }
        
        require('../App/Views/IndexView.php');
    }
}