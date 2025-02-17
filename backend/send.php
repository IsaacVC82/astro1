<?php
<<<<<<< HEAD
header("Access-Control-Allow-Origin:*"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Si la solicitud es OPTIONS (pre-flight), responder con un código 200 sin hacer nada
=======
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

>>>>>>> dev
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}
<<<<<<< HEAD

=======
>>>>>>> dev
// Cargar el autoload de Composer
require_once __DIR__ . '/vendor/autoload.php';

// Cargar el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

<<<<<<< HEAD
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
=======
// Acceder a las variables de entorno y validarlas
$mailjet_api_key = $_ENV['MAILJET_API_KEY'] ?? null;
$mailjet_secret_key = $_ENV['MAILJET_SECRET_KEY'] ?? null;
$from_email = filter_var($_ENV['FROM_EMAIL'] ?? 'no-reply@example.com', FILTER_SANITIZE_EMAIL);
$from_name = filter_var($_ENV['FROM_NAME'] ?? 'Isaac', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (!$mailjet_api_key || !$mailjet_secret_key || !$from_email || !$from_name) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Configuración de Mailjet inválida"]);
    exit;
}

use \Mailjet\Client;
use \Mailjet\Resources;

// Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y validar los datos recibidos
    $data = json_decode(file_get_contents('php://input'), true);

    $nombre = filter_var($data['nombre'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $celular = filter_var($data['celular'] ?? '', FILTER_SANITIZE_NUMBER_INT);

    if (!$nombre || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$celular) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Datos inválidos"]);
        exit;
    }

    // Configurar Mailjet
    $mailjet = new Client($mailjet_api_key, $mailjet_secret_key, true, ['version' => 'v3.1']);

    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => $from_email,
                    'Name' => $from_name
                ],
                'To' => [
                    [
                        'Email' => 'drawcommissions@gmail.com', 
                        'Name' => "Isaac"
                    ]
                ],
                'Subject' => "Correo de prueba",
                'HTMLPart' => "Hola <strong>$nombre</strong>, este es un mensaje de prueba. Tu número de celular es: <strong>$celular</strong>."
            ]
        ]
    ];

    try {
        $response = $mailjet->post(Resources::$Email, ['body' => $body]);

        if ($response->success()) {
            echo json_encode(["status" => "success", "message" => "Correo enviado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => "Error al enviar correo", "error" => $response->getData()]);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Excepción capturada: " . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>
>>>>>>> dev
