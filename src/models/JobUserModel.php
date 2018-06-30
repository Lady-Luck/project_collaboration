<?php namespace App\src\models;

use App\src\core\Field;
use App\src\core\Model;
use App\src\validators\StringValidator;

class JobUserModel extends Model  {

    protected function getFields() {

        $fields = array(
            'user_id' => new Field(new StringValidator(), true),
            'job_id' => new Field(new StringValidator(), true),
            'progress' => new Field(new StringValidator() ,true),
        );
        return $fields;
    }

}