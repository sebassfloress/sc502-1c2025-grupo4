<?php
// conexion a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$db = "aceros_griegos";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// proceso para guardar la cotizacion en la base de datos
$nombre = $_POST['nombre'] ?? '';
$correo = $_POST['email'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$tipo_acero = $_POST['acero'] ?? '';
$info = $_POST['info'] ?? '';

$sql = "INSERT INTO cotizaciones (nombre, correo, telefono, tipo_acero, informacion)
        VALUES ('$nombre', '$correo', '$telefono', '$tipo_acero', '$info')";
        
if ($conn->query($sql) === TRUE) {
    header("Location: indexContacto.html");
    exit();
} else {
    echo "Error al guardar la cotización: " . $conn->error;
}

$conn->close();
?>