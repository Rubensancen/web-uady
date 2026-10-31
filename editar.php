<?php
session_start();
require 'conexion.php';}
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== 'admin') { 
    header("Location: login.php"); 
    exit; 
}

$id = $_GET['id'] ?? null;
if (!$id) { 
    header("Location: dashboard.php"); 
    exit; 
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    if (!empty($password)) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, usuario = ?, password = ? WHERE id = ?");
        $stmt->execute([$nombre, $usuario, $passwordHash, $id]);
    } else {

        $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, usuario = ? WHERE id = ?");
        $stmt->execute([$nombre, $usuario, $id]);
    }

    header("Location: dashboard.php");
    exit;
}

$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuarioActual = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuarioActual) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 100vh; display: flex; justify-content: center; align-items: center; }
        .form-card { background: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); width: 100%; max-width: 400px; }
        .form-card h2 { margin-bottom: 24px; color: #333333; text-align: center; font-size: 24px; }
        .input-group { margin-bottom: 16px; }
        .input-group label { display: block; margin-bottom: 6px; color: #555555; font-size: 14px; font-weight: 600; }
        .input-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; }
        .input-group input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 5px rgba(102, 126, 234, 0.3); }
        .hint { font-size: 11px; color: #888; margin-top: 4px; display: block; }
        button { width: 100%; padding: 12px; background: #667eea; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.3s; margin-top: 10px; }
        button:hover { background: #5a6fd6; }
        .cancel-link { display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none; font-size: 14px; }
        .cancel-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="form-card">
    <h2>Modificar Usuario</h2>
    <form action="editar.php?id=<?= $id ?>" method="POST">
        <div class="input-group">
            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuarioActual['nombre']) ?>" required>
        </div>

        <div class="input-group">
            <label for="usuario">Nombre de Usuario:</label>
            <input type="text" id="usuario" name="usuario" value="<?= htmlspecialchars($usuarioActual['usuario']) ?>" required>
        </div>

        <div class="input-group">
            <label for="password">Nueva Contraseña:</label>
            <input type="password" id="password" name="password" placeholder="Opcional">
            <span class="hint">Déjala en blanco si no deseas cambiar la contraseña.</span>
        </div>

        <button type="submit">Actualizar Datos</button>
        <a href="dashboard.php" class="cancel-link">Cancelar</a>
    </form>
</div>

</body>
</html>