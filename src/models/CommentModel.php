<?php namespace App\src\models;

use App\src\core\Field;
use App\src\core\Model;
use App\src\validators\BooleanValidator;
use App\src\validators\DateTimeValidator;
use App\src\validators\StringValidator;

class CommentModel extends Model  {

    protected function getFields() {

        $fields = array(
            'comment' => new Field(new StringValidator(5), true),
            'user_id' => new Field(new StringValidator(), true),
            'job_id' => new Field(new StringValidator(), true),
            'created_at' => new Field(new DateTimeValidator() ,true),
            'is_private' => new Field(new StringValidator() ,true),
        );
        return $fields;
    }

    public function getCommentsForJob($job) {
        $comments = null;

        $sql = "SELECT * FROM comment WHERE job_id = " . $job . ";";
        $prep = $this->getConnection()->prepare($sql);
        $result = $prep->execute();
        if (!$result) {
            return $comments;
        }
        $comments = $prep->fetchAll(\PDO::FETCH_ASSOC);

        return $comments;
    }

}