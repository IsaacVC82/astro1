<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}
// Cargar el autoload de Composer
require_once __DIR__ . '/vendor/autoload.php';

// Cargar el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

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