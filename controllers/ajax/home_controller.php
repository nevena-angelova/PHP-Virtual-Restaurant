<?php
include 'models/email.php';

class HomeController
{
    public function sendMail()
    {
        if ($_POST) {
            $email = new Email();
            $email->send();
            if (count($email->getValidationErrors() == 0)) {
                echo 'Съобщението е изпратено успешно.';
            } else {
                ViewRenderer::render('views/inc/errors.php', $email->getValidationErrors());
            }
        }
    }
}