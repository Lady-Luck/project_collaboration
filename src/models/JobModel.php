<?php namespace App\src\models;

use App\src\core\Field;
use App\src\core\Model;
use App\src\validators\StringValidator;

class JobModel extends Model  {

    protected function getFields() {

        $fields = array(
            'name' => new Field(new StringValidator(), true),
            'user_id' => new Field(new StringValidator(), true),
            'project_id' => new Field(new StringValidator(), true),
            'deadline' => new Field(new StringValidator() ,true),
            'description' => new Field(new StringValidator() ,true),
            'progress' => new Field(new StringValidator() ,true),
        );
        return $fields;
    }

    public function applyToJob ($userId, $jobId) {
        $sql = "UPDATE job SET user_id = ? WHERE job_id = ?;";

        $prep = $this->getConnection()->prepare($sql);
        $result = $prep->execute([$userId, $jobId]);

        if (!$result) {
            return false;
        }
        return true;
    }

}