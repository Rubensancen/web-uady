<?php
require 'conexion.php';

$error = '';
$exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    // Encriptar contraseña
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Forzamos el rol como 'admin'
        $sql = "INSERT INTO usuarios (nombre, usuario, password, rol) VALUES (?, ?, ?, 'admin')";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$nombre, $usuario, $passwordHash]);

        $exito = "¡Administrador registrado con éxito! Ya puedes iniciar sesión.";
    } catch (PDOException $e) {
        $error = "Error al registrar (quizá el nombre de usuario ya existe).";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Administrador</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: linear-gradient(135deg, #f39c12 0%, #d68910 100%); height: 100vh; display: flex; justify-content: center; align-items: center; }
        .form-card { background: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); width: 100%; max-width: 400px; }
        .form-card h2 { margin-bottom: 24px; color: #333333; text-align: center; font-size: 24px; }
        .input-group { margin-bottom: 16px; }
        .input-group label { display: block; margin-bottom: 6px; color: #555555; font-size: 14px; font-weight: 600; }
        .input-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; }
        .error { color: #e74c3c; font-size: 13px; margin-bottom: 15px; text-align: center; display: block; }
        .exito { color: #27ae60; font-size: 13px; margin-bottom: 15px; text-align: center; display: block; }
        button { width: 100%; padding: 12px; background: #f39c12; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.3s; margin-top: 10px; }
        button:hover { background: #d68910; }
        .footer-text { text-align: center; margin-top: 20px; font-size: 14px; color: #666666; }
        .footer-text a { color: #f39c12; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

<div class="form-card">
    <h2>👑 Nuevo Administrador</h2>
    
    <?php if(!empty($error)): ?>
        <span class="error"><?= htmlspecialchars($error) ?></span>
    <?php endif; ?>
    <?php if(!empty($exito)): ?>
        <span class="exito"><?= htmlspecialchars($exito) ?></span>
    <?php endif; ?>

    <form action="registro_admin.php" method="POST">
        <div class="input-group">
            <label>Nombre Completo:</label>
            <input type="text" name="nombre" required>
        </div>
        <div class="input-group">
            <label>Usuario:</label>
            <input type="text" name="usuario" required>
        </div>
        <div class="input-group">
            <label>Contraseña:</label>
            <input type="password" name="password" minlength="6" required>
        </div>
        <button type="submit">Registrar Administrador</button>
    </form>
    
    <div class="footer-text">
        <a href="login.php">← Volver al Login</a>
    </div>
</div>

</body>
</html>