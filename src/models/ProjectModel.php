<?php namespace App\src\models;

use App\src\core\Field;
use App\src\core\Model;
use App\src\validators\DateTimeValidator;
use App\src\validators\StringValidator;

class ProjectModel extends Model {

    protected function getFields() {

        $fields = array(
            'name' => new Field(new StringValidator(), true),
            'user_id' => new Field(new StringValidator() ,true),
            'created_at' => new Field(new DateTimeValidator() ,true),
            'progress' => new Field(new StringValidator() ,true),
        );
        return $fields;
    }

    public function findProjectsByUser ($user) {
        $projects = null;


        $sql = "SELECT * FROM project WHERE user_id = " . $user->user_id . ";";
        $prep = $this->getConnection()->prepare($sql);
        $result = $prep->execute();
        if (!$result) {
            return $projects;
        }
        $projects = $prep->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($projects as $key => $project) {
            $projects[$key]['user'] = $user;
        }

        return $projects;
    }
}