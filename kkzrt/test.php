<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function testEmail() {
    $email = new PHPMailer(true);

    try {
        // SMTP beállítások
        $email->isSMTP();
        $email->Host = $_ENV['SMTP_HOST'];
        $email->SMTPAuth = true;
        $email->Username = $_ENV['SMTP_USERNAME'];
        $email->Password = $_ENV['SMTP_PASSWORD'];
        $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $email->Port = $_ENV['SMTP_PORT'];
        $email->CharSet = 'UTF-8';

        // Email beállítások
        $email->setFrom($_ENV['SMTP_FROM'], $_ENV['SMTP_FROM_NAME']);
        $email->addAddress('laszlobogdan0619@gmail.com');

        // tartalom
        $email->isHTML(true);
        $email->Subject = 'Teszt Email - KKZRT';
        
        $email->Body = "
            <html>
            <body>
                <h2>Email Teszt</h2>
                <p>Ha ezt az emailt megkaptad, akkor a beállítások sikeresek!</p>
                <p>Időbélyeg: " . date('Y-m-d H:i:s') . "</p>
            </body>
            </html>
        ";

        $email->send();
        echo "Teszt email sikeresen elküldve!";
    } catch (Exception $e) {
        echo "Hiba történt az email küldése során: " . $email->ErrorInfo;
    }
}

// futtatás
testEmail();