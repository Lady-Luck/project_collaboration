<?php namespace App\src\models;

use App\src\core\Field;
use App\src\core\Model;
use App\src\validators\DateTimeValidator;
use App\src\validators\StringValidator;

class CommentModel extends Model  {

    protected function getFields() {

        $fields = array(
            'comment' => new Field(new StringValidator(), true),
            'user_id' => new Field(new StringValidator(), true),
            'job_id' => new Field(new StringValidator(), true),
            'created_at' => new Field(new DateTimeValidator() ,true),
        );
        return $fields;
    }

}