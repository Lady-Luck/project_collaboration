<?php namespace App\src\core;

final class Field {

    private $validator;
    private $editable;

    public function __construct(Validator $validator, $editable)
    {
        $this->validator = $validator;
        $this->editable = $editable;
    }

    public function isValid ($value) {
        return $this->validator->isValid($value);
    }

    public function isEditable () {
        return $this->editable;
    }


}