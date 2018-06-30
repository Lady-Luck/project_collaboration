<?php namespace App\src\models;

use App\src\core\Field;
use App\src\core\Model;
use App\src\validators\StringValidator;

class InvitationModel extends Model {

    protected function getFields() {

        $fields = array(
            'project_id' => new Field(new StringValidator(), true),
            'user_id' => new Field(new StringValidator() ,true)
        );
        return $fields;
    }

    public function acceptInvitation ($id) {
        $sql = "UPDATE invitation SET is_accepted = 1 WHERE invitation_id = ?;";

        $prep = $this->getConnection()->prepare($sql);
        $result = $prep->execute([$id]);

        if (!$result) {
            return false;
        }
        return true;
    }

}