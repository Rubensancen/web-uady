<?php
$host = 'localhost';
$dbname = 'Web'; // Nombre de tu base de datos
$username = 'root';
$password = ''; // En XAMPP la contraseña por defecto es vacía

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión a la base de datos: " . $e->getMessage());
}
?>