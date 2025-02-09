<?php
// Habilitar CORS para permitir peticiones desde el frontend
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Manejar preflight
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    http_response_code(200);
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require '../vendor/autoload.php'; // Carga PHPMailer y phpdotenv

// Cargar variables de entorno desde .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Activar modo debug (cambiar a false en producción)
$DEBUG_MODE = true;

if ($DEBUG_MODE) {
    // Mostrar variables de entorno en JSON para depuración
    echo json_encode([
        "status" => "debug",
        "message" => "Variables de entorno cargadas",
        "env" => [
            "SMTP_HOST" => $_ENV['SMTP_HOST'] ?? "No definido",
            "SMTP_USERNAME" => $_ENV['SMTP_USERNAME'] ?? "No definido",
            "SMTP_PASSWORD" => !empty($_ENV['SMTP_PASSWORD']) ? "Definida" : "No definida",
            "SMTP_ENCRYPTION" => $_ENV['SMTP_ENCRYPTION'] ?? "No definido",
            "SMTP_PORT" => $_ENV['SMTP_PORT'] ?? "No definido"
        ]
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") {
    // Obtener y sanitizar los datos del formulario
    $nombre = htmlspecialchars($_POST["nombre"] ?? "", ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST["email"] ?? "", ENT_QUOTES, 'UTF-8');
    $telefono = htmlspecialchars($_POST["celular"] ?? "", ENT_QUOTES, 'UTF-8');

    // Validar los datos del formulario
    if (empty($nombre) || empty($email) || empty($telefono)) {
        echo json_encode(["status" => "error", "message" => "Faltan datos obligatorios."]);
        exit;
    }

    $mail = new PHPMailer(true);
    
    try {
        // Configuración del servidor SMTP usando variables de entorno
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = $_ENV['SMTP_ENCRYPTION'];
        $mail->Port = $_ENV['SMTP_PORT'];

        // Configuración del correo
        $mail->setFrom($_ENV['SMTP_FROM_EMAIL'], $_ENV['SMTP_FROM_NAME']);
        $mail->addAddress('destinatario@ejemplo.com', 'Destinatario'); 
        $mail->Subject = 'Nuevo Mensaje de Contacto';
        $mail->Body    = "Nombre: $nombre\nEmail: $email\nTeléfono: $telefono";
        
        // Enviar el correo
        if ($mail->send()) {
            echo json_encode(["status" => "success", "message" => "Correo enviado con éxito."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al enviar el correo."]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Acceso no permitido."]);
}
?>
