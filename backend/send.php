<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require '../vendor/autoload.php'; // Carga PHPMailer y phpdotenv

// Cargar variables de entorno desde .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $telefono = $_POST["celular"]; // Asegúrate de que el formulario tiene este campo
    
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
