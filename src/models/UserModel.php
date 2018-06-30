<?php namespace App\src\models;

use App\src\core\Field;
use App\src\validators\StringValidator;
use App\src\validators\EmailValidator;

class UserModel extends Model {

    protected function getFields() {

        $fields = array(
            'email' => new Field(new EmailValidator(), true),
            'first_name' => new Field(new StringValidator() ,true),
            'last_name' => new Field(new StringValidator() ,true),
            'password' => new Field(new StringValidator(7, 120), true)
        );
        return $fields;
    }



}