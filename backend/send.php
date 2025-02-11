<?php
header("Access-Control-Allow-Origin:*"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Si la solicitud es OPTIONS (pre-flight), responder con un código 200 sin hacer nada
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Cargar el autoload de Composer
require_once __DIR__ . '/vendor/autoload.php';

// Cargar el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Acceder a las variables de entorno
$smtp_host = $_ENV['SMTP_HOST'] ?? null;
$smtp_port = $_ENV['SMTP_PORT'] ?? 1025;
$smtp_auth = $_ENV['SMTP_AUTH'] ?? 'false';
$from_email = $_ENV['FROM_EMAIL'] ?? 'no-reply@example.com';
$from_name = $_ENV['FROM_NAME'] ?? 'Isaac';

// Cargar PHPMailer
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inicializar PHPMailer
$mail = new PHPMailer(true);

// Filtrar los datos recibidos
$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Validar los datos
if (!$nombre || !$email || !$celular) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
    exit;
}

// Configuración de PHPMailer
try {
    $mail->isSMTP();
    $mail->Host = 'localhost';
    $mail->Port = 1025; 
    $mail->SMTPAuth = 'false'; 

    // Configurar el remitente
    if (!$from_email || !$from_name) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Configuración de remitente inválida"]);
        exit;
    }
    $mail->setFrom($from_email, $from_name);

    // Configurar el destinatario
    $mail->addAddress($email, $nombre);

    // Configuración del mensaje
    $mail->isHTML(true);
    $mail->Subject = 'Correo de prueba';
    $mail->Body = "Hola $nombre, este es un mensaje de prueba. Tu número de celular es: $celular.";

    // Enviar el correo
    if (!$mail->send()) {
        throw new Exception('No se pudo enviar el mensaje.');
    }

echo json_encode(["status" => "success", "message" => "Correo enviado correctamente"]);


    

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Error: {$e->getMessage()}"]);
}
?>
