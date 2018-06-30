<?php namespace App\src\models;

use App\src\core\Field;
use App\src\validators\DateTimeValidator;
use App\src\validators\StringValidator;

class ProjectModel extends Model {

    protected function getFields() {

        $fields = array(
            'project_name' => new Field(new StringValidator(), true),
            'project_author' => new Field(new StringValidator() ,true),
            'project_date' => new Field(new DateTimeValidator() ,true),
            'project_progress' => new Field(new StringValidator() ,true),
        );
        return $fields;
    }

    public function findProjectsByUser ($user) {
        $projects = null;

        $sql = "SELECT * FROM projects WHERE project_author = " . $user->id . ";";
        $prep = $this->getConnection()->prepare($sql);
        $result = $prep->execute();
        if (!$result) {
            return $projects;
        }
        $projects = $prep->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($projects as $key => $project) {
            $projects[$key]['project_author'] = $user;
        }

        return $projects;
    }

}