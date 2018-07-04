<?php namespace App\src\validators;

use App\src\core\Validator;

class StringValidator implements Validator {
    private $minLength;
    private $maxLength;

    public function __construct($min = 0, $max = 255)
    {
        $this->minLength = $min;
        $this->maxLength = $max;
    }

    public function setMinLength (int $length) {
        $this->minLength = max(0, $length);
    }

    public function setMaxLength (int $length) {
        $this->maxLength = max(1, $length);
    }

    public function isValid($value) {
        $pattern = '/^.{' . $this->minLength . ',' . $this->maxLength . '}$/';
        return boolval(preg_match($pattern, $value));
    }
}