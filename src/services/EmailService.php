<?php namespace App\src\services;

use PHPMailer\PHPMailer\PHPMailer;

class EmailService {

    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer();

        $this->mailer->isSMTP();
        $this->mailer->Host = MAIL_HOST;
        $this->mailer->Port = MAIL_PORT;
        $this->mailer->SMTPSecure = MAIL_PROTOCOL;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = MAIL_USERNAME;
        $this->mailer->Password = MAIL_PASSWORD;

        $this->mailer->setFrom(MAIL_USERNAME);

        $this->mailer->isHTML(true);

    }

    public function sendEmail ($to, $subject = null, $message = null) {

        $this->mailer->Body = $message;
        $this->mailer->Subject = $subject;
        $this->mailer->addAddress($to);

        $this->mailer->send();
    }

}