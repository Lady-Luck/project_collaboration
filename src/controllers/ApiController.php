<?php namespace App\src\controllers;

use App\src\core\Request;
use App\src\models\InvitationModel;

class ApiController extends Controller {

    public function invitationAcceptance(Request $request) {
        $id = $request->getParams()[0];
        $success = false;

        $invitationModel = new InvitationModel($this->getDatabaseConnection());
        $invitation = $invitationModel->getById($id);

        if ($invitation) {
            $success = $invitationModel->acceptInvitation($id);
        }

        return $this->twig->render('/invitation.html.twig', array(
            'success' => $success,
            'invitation' => $invitation
        ));
    }
}