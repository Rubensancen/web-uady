<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$stmt = $conexion->query("SELECT id, nombre, usuario, rol, creado_en FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Gestión de Administrador</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: #f4f7f6; padding: 30px; }
        .container { max-width: 950px; margin: auto; background: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px; }
        .top-bar h2 { color: #333333; font-size: 22px; }
        .btn-logout { background: #e74c3c; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 600; transition: background 0.3s; }
        .btn-logout:hover { background: #c0392b; }
        h3 { color: #555555; margin-bottom: 15px; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #e0e0e0; padding: 12px; text-align: left; font-size: 14px; }
        th { background-color: #f39c12; color: white; font-weight: 600; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; color: white; font-size: 13px; font-weight: 600; margin-right: 5px; display: inline-block; }
        .btn-edit { background: #3498db; }
        .btn-edit:hover { background: #2980b9; }
        .btn-delete { background: #e74c3c; }
        .btn-delete:hover { background: #c0392b; }
    </style>
</head>
<body>

<div class="container">
    <div class="top-bar">
        <h2>👑 Panel de Gestión (Admin: <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>)</h2>
        <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>

    <h3>Usuarios Registrados en el Sistema</h3>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Fecha de Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['nombre']) ?></td>
                <td><?= htmlspecialchars($u['usuario']) ?></td>
                <td><?= htmlspecialchars($u['rol']) ?></td>
                <td><?= $u['creado_en'] ?></td>
                <td>
                    <a href="editar.php?id=<?= $u['id'] ?>" class="btn btn-edit">Modificar</a>
                    <a href="eliminar.php?id=<?= $u['id'] ?>" class="btn btn-delete" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>