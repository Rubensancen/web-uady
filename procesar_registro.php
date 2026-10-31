<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    try {
        $sql = "INSERT INTO usuarios (nombre, usuario, password) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$nombre, $usuario, $passwordHash]);

        header("Location: login.php?msg=registrado");
        exit;
    } catch (PDOException $e) {
        die("Error al registrar (quizá el usuario ya existe): " . $e->getMessage());
    }
}
?>