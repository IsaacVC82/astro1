<?php
header("Content-Type: application/json");

// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
    exit;
}

// Obtener los datos del formulario
$nombre = trim($_POST["nombre"] ?? "");
$email = trim($_POST["email"] ?? "");
$telefono = trim($_POST["celular"] ?? "");

// Validaciones
$errores = [];

// Validar nombre 
if (strlen($nombre) < 9 || strlen($nombre) > 128) {
    $errores[] = "El nombre debe tener entre 9 y 128 caracteres.";
}

// Validar correo electrónico (formato y longitud)
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) < 9 || strlen($email) > 128) {
    $errores[] = "El correo electrónico debe ser válido y tener entre 9 y 128 caracteres.";
}

// Validar teléfono 
if (!preg_match("/^\d{12}$/", $telefono)) {
    $errores[] = "El teléfono debe tener exactamente 12 dígitos numéricos.";
}

// Si hay errores, devolverlos
if (!empty($errores)) {
    echo json_encode(["status" => "error", "errors" => $errores]);
    exit;
}

// Si todo está bien, responder con éxito
echo json_encode(["status" => "success"]);
exit;
?>
