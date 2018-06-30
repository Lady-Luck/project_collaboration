<?php namespace App\src\validators;

use App\src\core\Validator;

class EmailValidator implements Validator {

    public function isValid($value) {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
}