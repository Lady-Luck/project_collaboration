<?php namespace App\src\controllers;

use App\src\core\Request;
use App\src\models\CommentModel;

class CommentController extends Controller {

    public function newComment(Request $request) {

        $job = $request->getParams()[1];

        if ($request->getMethod() == 'POST') {

            $data = $request->getData();
            $data = $data['comment_form'];

            $data['user_id'] = $this->getUser()->user_id;
            $today = new \DateTime();
            $data['created_at']   = $today->format('Y-m-d H:i:s');

            $commentModel = new CommentModel($this->getDatabaseConnection());
            $commentModel->add($data);

            $this->redirect(BASE_URL . '/job/' . $job);

        }

        return $this->twig->render('/comment/comment_form.html.twig', array(
            'user' => $this->getUser(),
            'job' => $job
        ));
    }


}