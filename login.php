<?php
session_start();
require 'conexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];
    $tipo_login = $_POST['tipo_login'] ?? 'usuario';

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['user_rol'] = $user['rol'];

        if ($tipo_login === 'admin') {
            if ($user['rol'] === 'admin') {
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Esta cuenta no tiene privilegios de administrador.";
            }
        } else {
            header("Location: index.php");
            exit;
        }
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 100vh; display: flex; justify-content: center; align-items: center; }
        .form-card { background: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); width: 100%; max-width: 400px; text-align: center; }
        .form-card h2 { margin-bottom: 24px; color: #333333; font-size: 24px; }
        .input-group { margin-bottom: 16px; text-align: left; }
        .input-group label { display: block; margin-bottom: 6px; color: #555555; font-size: 14px; font-weight: 600; }
        .input-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; }
        .error { color: #e74c3c; font-size: 13px; margin-bottom: 15px; display: block; }
        button { width: 100%; padding: 12px; background: #667eea; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background 0.3s; margin-top: 10px; }
        button:hover { background: #5a6fd6; }
        .footer-text { margin-top: 20px; font-size: 14px; color: #666666; }
        .footer-text a { color: #667eea; text-decoration: none; font-weight: 600; }
        
        .btn-admin {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        .btn-crown {
            background: #f39c12;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }
        .btn-crown:hover {
            background: #d68910;
        }
    </style>
</head>
<body>

<div class="form-card">
    <h2>Iniciar Sesión</h2>
    
    <?php if(!empty($error)): ?>
        <span class="error"><?= htmlspecialchars($error) ?></span>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <input type="hidden" name="tipo_login" value="usuario">
        <div class="input-group">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>
        <div class="input-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Entrar al Sitio</button>
    </form>
    
    <div class="footer-text">
        ¿No tienes cuenta? <a href="registro.php">Regístrate</a>
    </div>

    <div class="btn-admin">
        <button type="button" class="btn-crown" onclick="toggleAdminLogin()">👑 Acceso Administrador</button>
    </div>
</div>

<div id="adminModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;">
    <div style="background:white; padding:30px; border-radius:10px; width:350px; text-align:center;">
        <h3>Panel Administrador</h3>
        <form action="login.php" method="POST" style="margin-top:15px;">
            <input type="hidden" name="tipo_login" value="admin">
            <div class="input-group" style="text-align:left; margin-bottom:12px;">
                <label>Usuario:</label>
                <input type="text" name="usuario" required style="width:100%; padding:8px;">
            </div>
            <div class="input-group" style="text-align:left; margin-bottom:15px;">
                <label>Contraseña:</label>
                <input type="password" name="password" required style="width:100%; padding:8px;">
            </div>
            <button type="submit" style="background:#f39c12; width:100%; padding:10px; color:white; border:none; border-radius:4px; cursor:pointer;">Entrar a Gestión</button>
            <button type="button" onclick="toggleAdminLogin()" style="background:#ccc; color:#333; margin-top:8px; width:100%; padding:8px; border:none; border-radius:4px; cursor:pointer;">Cancelar</button>
        </form>
        
        <div style="margin-top: 15px; font-size: 13px;">
            <a href="registro_admin.php" style="color: #f39c12; text-decoration: none; font-weight: 600;">+ Registrar nuevo Administrador</a>
        </div>
    </div>
</div>

<script>
function toggleAdminLogin() {
    const modal = document.getElementById('adminModal');
    modal.style.display = modal.style.display === 'flex' ? 'none' : 'flex';
}
</script>

</body>
</html>