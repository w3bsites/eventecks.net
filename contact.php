<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $service = htmlspecialchars($_POST['service']);
    $message = htmlspecialchars($_POST['message']);
    
    // Configuration de l'email
    $to = "eventecks@etik.com";
    $subject = "Nouveau message depuis le site EVENTECKS - " . $service;
    
    // Construction du message
    $email_message = "
    <html>
    <head>
        <title>Nouveau contact EVENTECKS</title>
        <style>
            body { font-family: Arial, sans-serif; }
            .header { background: #3B82F6; color: white; padding: 20px; }
            .content { padding: 20px; }
            .footer { background: #f3f4f6; padding: 10px; text-align: center; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h2>Nouveau message depuis eventecks.net</h2>
        </div>
        <div class='content'>
            <p><strong>Nom:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Téléphone:</strong> $phone</p>
            <p><strong>Service concerné:</strong> $service</p>
            <p><strong>Message:</strong><br>$message</p>
        </div>
        <div class='footer'>
            <p>Message envoyé le " . date('d/m/Y à H:i') . "</p>
        </div>
    </body>
    </html>
    ";
    
    // Headers pour l'email HTML
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $email" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Envoi de l'email
    if (mail($to, $subject, $email_message, $headers)) {
        // Email envoyé avec succès
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Votre message a été envoyé avec succès !"]);
    } else {
        // Erreur d'envoi
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Une erreur s'est produite lors de l'envoi du message."]);
    }
} else {
    // Méthode non autorisée
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Méthode non autorisée."]);
}
?>
