<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .edit-form {
            display: none;
        }
        .editing .view-mode {
            display: none;
        }
        .editing .edit-form {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestión de Usuarios</h1>
        
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success"><?= $successMessage ?></div>
        <?php endif; ?>
        
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <form action="../Actions/SearchUser.php" method="POST">
                <div class="input-group w-100">
                    <input type="text" class="form-control" name="searchInput" placeholder="Buscar usuario por nombre o correo">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </form>

            <form action="../Actions/CreateUser.php" method="GET" style="display: inline;">
                <button type="submit" class="btn btn-primary">Crear Usuario</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaUsuarios">
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="4" class="text-center">No se encontraron usuarios</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr id="user-<?= $user['id'] ?? ($user->id ?? '') ?>" class="<?= ($_GET['edit'] ?? '') == ($user['id'] ?? ($user->id ?? '')) ? 'editing' : '' ?>">
                                <td><?= $user['id'] ?? ($user->id ?? '') ?></td>
                                
                                
                                <td class="view-mode"><?= htmlspecialchars($user['name'] ?? ($user->name ?? '')) ?></td>
                                <td class="view-mode"><?= htmlspecialchars($user['email'] ?? ($user->email ?? '')) ?></td>
                                
                                
                                <td colspan="2" class="edit-form">
                                    <form action="../Actions/UpdateUser.php" method="POST" class="row g-2">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?? ($user->id ?? '') ?>">
                                        
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="name" 
                                                   value="<?= htmlspecialchars($user['name'] ?? ($user->name ?? '')) ?>" required>
                                        </div>
                                        
                                        <div class="col-md-5">
                                            <input type="email" class="form-control" name="email"
                                                   value="<?= htmlspecialchars($user['email'] ?? ($user->email ?? '')) ?>" required>
                                        </div>
                                        
                                        <div class="col-md-2 d-flex">
                                            <button type="submit" class="btn btn-success btn-sm me-1">Guardar</button>
                                            <a href="?cancel=1" class="btn btn-secondary btn-sm">Cancelar</a>
                                        </div>
                                    </form>
                                </td>
                                
                                <td class="view-mode">
                                    <a href="?edit=<?= $user['id'] ?? ($user->id ?? '') ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="../Actions/DeleteUser.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?? ($user->id ?? '') ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.search.includes('cancel=1')) {
                window.location.href = window.location.pathname;
            }
        });
    </script>
</body>
</html>