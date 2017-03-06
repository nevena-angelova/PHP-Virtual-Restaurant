<?php

class User
{
    protected $id;
    protected $username;
    protected $pass;
    protected $validation_errors = array();
    protected $validation_rules = array(
        'username_len' => array('min' => 3, 'max' => 20, 'msg' => 'Невалидно потребителско име (от 3 до 20 символа).'),
        'pass_len' => array('min' => 6, 'max' => 20, 'msg' => 'Невалиднa парола (от 6 до 20 символа).'),
    );

    function getId()
    {
        return $this->id;
    }

    function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $username_trimmed = trim($username);
        if (mb_strlen($username_trimmed) >= $this->validation_rules['username_len']['min'] && mb_strlen($username_trimmed) <= $this->validation_rules['username_len']['max']) {
            $this->username = $username_trimmed;
        } else {
            $this->validation_errors['username'] = $this->validation_rules['username_len']['msg'];
        }
    }

    function getPass()
    {
        return $this->pass;
    }

    public function setPass($pass)
    {
        $pass_trimmed = trim($pass);
        if (mb_strlen($pass_trimmed) >= $this->validation_rules['pass_len']['min'] && mb_strlen($pass_trimmed) <= $this->validation_rules['pass_len']['max']) {
            $this->pass = $pass_trimmed;
        } else {
            $this->validation_errors['pass'] = $this->validation_rules['pass_len']['msg'];
        }
    }

    public function getValidationRules()
    {
        return $this->validation_rules;
    }

    public function getValidationErrors()
    {
        return $this->validation_errors;
    }
}
