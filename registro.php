<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .form-card h2 {
            margin-bottom: 24px;
            color: #333333;
            text-align: center;
            font-size: 24px;
        }

        .input-group {
            margin-bottom: 16px;
        }

        .input-group label {
            display: block;
            margin-bottom: 6px;
            color: #555555;
            font-size: 14px;
            font-weight: 600;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .input-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }

        .error {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background: #5a6fd6;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666666;
        }

        .footer-text a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-card">
    <h2>Crear Cuenta</h2>
    <form id="formRegistro" action="procesar_registro.php" method="POST" onsubmit="return validarRegistro()">
        
        <div class="input-group">
            <label for="nombre">Nombre Completo:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Ejemplo Ruben Sancen" required>
        </div>

        <div class="input-group">
            <label for="usuario">Nombre de Usuario:</label>
            <input type="text" id="usuario" name="usuario" placeholder="Ejemplo Sancen17" required>
        </div>

        <div class="input-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" placeholder="Mínimo 6 caracteres" minlength="6" required>
        </div>

        <div class="input-group">
            <label for="re_password">Confirmar Contraseña:</label>
            <input type="password" id="re_password" placeholder="Repite tu contraseña" required>
        </div>
        
        <span id="errorMsg" class="error"></span>

        <button type="submit">Registrarse</button>
    </form>
    
    <div class="footer-text">
        ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
    </div>
</div>

<script>
function validarRegistro() {
    const pass = document.getElementById("password").value;
    const rePass = document.getElementById("re_password").value;
    const errorMsg = document.getElementById("errorMsg");

    if (pass !== rePass) {
        errorMsg.textContent = "Las contraseñas no coinciden";
        return false;
    }
    
    errorMsg.textContent = "";
    return true;
}
</script>

</body>
</html>