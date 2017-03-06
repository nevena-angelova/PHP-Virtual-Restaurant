<?php

class Email
{
    private $to = 'nevena1234@gmail.com';
    private $subject = 'Запитване';
    private $message;
    private $from;
    private $validation_errors;
    protected $validation_rules = array(
        'message' => array('min' => 3, 'max' => 500, 'msg' => 'Невалидно съобщение име (от 3 до 500 символа).'),
        'email_len' => array('max' => 50, 'msg' => 'Невалиден email.')
    );

    public function setMessage($message)
    {
        $message_trimmed = trim($message);
        if (mb_strlen($message_trimmed) >= $this->validation_rules['message']['min'] && mb_strlen($message_trimmed) <= $this->validation_rules['message']['max']) {
            $this->$message = $message_trimmed;
        } else {
            $this->validation_errors['message'] = $this->validation_rules['message']['msg'];
        }
    }

    public function setFrom($email)
    {
        $email_trimmed = trim($email);
        if ($email_trimmed != NULL && filter_var($email_trimmed, FILTER_VALIDATE_EMAIL)
            && mb_strlen($email_trimmed) <= $this->validation_rules['email_len']['max']
        ) {
            $this->from = $email_trimmed;
        } else {
            $this->validation_errors['email'] = $this->validation_rules['email_len']['msg'];
        }
    }

    public function getValidationErrors()
    {
        return $this->validation_errors;
    }

    public function send()
    {
        $this->setMessage($_POST['message']);
        $this->setFrom($_POST['email']);

        if (count($this->validation_errors) === 0) {
            $headers = 'From: ' . $this->from . "\r\n" . 'X-Mailer: PHP/' . phpversion();

            mail($this->to, $this->subject, $this->message, $headers);
        }
    }
}