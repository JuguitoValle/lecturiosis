<?php
namespace App\Controllers;
use App\Models\User;

class IndexController
{
    public function __construct()
    {
        // Obtener los usuarios
        $users = User::get();

        // Pasar los datos a la vista
        $this->renderView('IndexView.php', ['users' => $users]);
    }

    protected function renderView($viewName, $data = [])
    {
        // Extraer las variables del array $data para que estén disponibles en la vista
        extract($data);

        // Ruta correcta a la vista (ajusta según tu estructura de directorios)
        $viewPath = __DIR__ . '/../Views/' . $viewName;

        if (file_exists($viewPath)) {
            require($viewPath);
        } else {
            throw new \Exception("Vista no encontrada: $viewPath");
        }
    }
}