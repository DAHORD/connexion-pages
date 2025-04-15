<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Assure-toi que PHPMailer est bien installé

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse email invalide.";
        exit();
    }

    $reset_link = "http://localhost/connexion/reset_password.php?email=" . urlencode($email);

    $mail = new PHPMailer(true);

    try {
        // Serveur SMTP Free
        $mail->isSMTP();
        $mail->Host       = 'smtp.free.fr';
        $mail->Port       = 587; // Tu peux aussi essayer 25 si 587 ne fonctionne pas
        $mail->SMTPAuth   = false; // Free n'exige pas toujours l'authentification
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ou '' si tu veux sans chiffrement

        // Adresse de l’expéditeur
        $mail->setFrom('killian.pub@free.fr', 'Support - CR by Fan');
        $mail->addAddress($email);

        // Contenu de l’email
        $mail->isHTML(true);
        $mail->Subject = 'Réinitialisation de votre mot de passe';
        $mail->Body    = "
            Bonjour,<br><br>
            Vous avez demandé à réinitialiser votre mot de passe.<br>
            Cliquez sur le lien ci-dessous pour continuer :<br><br>
            <a href='$reset_link'>$reset_link</a><br><br>
            Si vous n'avez pas fait cette demande, ignorez cet email.
        ";

        $mail->send();
        echo "Un email a été envoyé à <strong>$email</strong> avec un lien de réinitialisation.";
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi du mail via Free : {$mail->ErrorInfo}";
    }
} else {
    header("Location: forgot_password.html");
    exit();
}
?>
