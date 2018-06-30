<?php namespace App\src\validators;

use App\src\core\Validator;

class DateTimeValidator implements Validator {

    public function isValid($value) {
        return true;
    }
}