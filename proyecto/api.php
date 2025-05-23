<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

$host = "localhost";
$user = "root";
$password = "";
$db = "aceros_griegos";

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombre = $_POST['nombre'] ?? '';
$correo = $_POST['email'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$tipo_acero = $_POST['acero'] ?? '';
$info = $_POST['info'] ?? '';

$sql = "INSERT INTO cotizaciones (nombre, correo, telefono, tipo_acero, informacion)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $nombre, $correo, $telefono, $tipo_acero, $info);

if ($stmt->execute()) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'byxdyl@gmail.com';       
        $mail->Password = 'rybrlvnirqxilmov';            
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('byxdyl@gmail.com', 'Aceros Griegos');
        $mail->addAddress('byxdyl@gmail.com', 'Departamento Financiero');

        $mail->Subject = "Nueva Cotización de $nombre";
        $mail->Body    = "Se ha recibido una nueva solicitud de cotización:\n\n" .
                         "Nombre: $nombre\n" .
                         "Correo: $correo\n" .
                         "Teléfono: $telefono\n" .
                         "Tipo de Acero: $tipo_acero\n" .
                         "Información Adicional: $info";

        $mail->send();
    } catch (Exception $e) {
        echo "⚠️ Error al enviar el correo: {$mail->ErrorInfo}";
    }

   
    header("Location: indexContacto.html");
    exit();
} else {
    echo "❌ Error al guardar en la base de datos: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>