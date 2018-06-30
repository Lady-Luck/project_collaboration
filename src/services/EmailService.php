<?php namespace App\src\services;

class EmailService {

    private $headers;
    private $from = 'stosic@test.rs';

    public function __construct()
    {
        $headers = "From: " . $this->from . "\r\n";
        $headers .= "Reply-To: ". $this->from . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $this->headers = $headers;
    }

    public function sendEmail ($to, $subject = null, $message = null, $headers = null) {

        if (empty($headers)) {
            $headers = $this->headers;
        }

        mail($to, $subject, $message, $headers);

    }




}