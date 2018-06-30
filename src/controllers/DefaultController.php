<?php namespace App\src\controllers;

use App\src\models\ProjectModel;
use App\src\models\InvitationModel;
use App\src\models\UserModel;

class DefaultController extends Controller {

        public function home() {

            $user = $this->getUser();
            if (empty($user)) {
                $this->redirect('login');
            }

            $projectModel = new ProjectModel($this->getDatabaseConnection());
            $projects = $projectModel->getAll();

            $userModel = new UserModel($this->getDatabaseConnection());
            foreach ($projects as $key => $project) {
                $author = null;
                $author = $userModel->getById($project->user_id);
                $author = get_object_vars($author);

                $projects[$key]->user = $author;
            }

            $invitationModel = new InvitationModel($this->getDatabaseConnection());
            $invitations = $invitationModel->getByFieldName('user_id',$user->user_id);

            foreach ($invitations as $value){
                $project = (array)$projectModel->getOneByFieldName('id', $value->project_id);
                $projects[] = $project;
            }

            $br = $progressSum = 0;
            if ($projects) {
                foreach ($projects as $value) if (!empty($value->progress)) {
                    $br++;
                    $progressSum = $progressSum + $value->progress;
                }
            }

            return $this->twig->render('/home.html.twig', array(
                'user' => $user,
                'projects' => $projects,
                'progressSum' => $progressSum ? $progressSum/$br : 0
            ));


        }

    }