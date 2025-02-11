<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mail_to = "comunidadcristianavida.cr@gmail.com";

    $subject = trim($_POST["subject"]);
    $name = preg_replace(array("/\r/", "/\n/"), " ", strip_tags(trim($_POST["name"])));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST["phone"]);
    $message = trim($_POST["message"]);

    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($phone) || empty($subject) || empty($message)) {
        http_response_code(400);
        echo "Por favor completa el formulario y vuelve a intentarlo.";
        exit;
    }

    $content = "Nombres: $name\n";
    $content .= "E-mail: $email\n\n";
    $content .= "Telefono: $phone\n";
    $content .= "Mensaje:\n$message\n";

    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n"; // Añadido para facilitar la respuesta
    $headers .= "Content-Type: text/plain; charset=UTF-8"; // Codificación UTF-8

    $success = mail($mail_to, $subject, $content, $headers);

    if ($success) {
        http_response_code(200);
        echo "¡Gracias! Tu mensaje ha sido enviado.";
    } else {
        http_response_code(500);
        echo "Oops! Algo salió mal, no pudimos enviar tu mensaje.";
    }

} else {
    http_response_code(403);
    echo "Hubo un problema con tu envío, intenta de nuevo.";
}

?>