<?php namespace App\src\controllers;

use App\src\core\Request;
use App\src\models\InvitationModel;
use App\src\models\JobModel;
use App\src\models\ProjectModel;
use App\src\models\UserModel;
use App\src\services\EmailService;
use App\src\validators\EmailValidator;

class ProjectController extends Controller {

    public function newProject(Request $request) {

        if ($request->getMethod() == 'POST') {

            $data = $request->getData();
            $data = $data['project_form'];

            $data['user_id'] = $this->getUser()->user_id;
            $today = new \DateTime();
            $data['created_at']   = $today->format('Y-m-d H:i:s');

            $projectModel = new ProjectModel($this->getDatabaseConnection());
            $projectModel->add($data);

            $this->redirect('home');

        }

        return $this->twig->render('/project.html.twig', array(
            'user' => $this->getUser()
        ));
    }

    public function project (Request $request) {
        $id = $request->getParams()[0];

        $projectModel = new ProjectModel($this->getDatabaseConnection());
        $project = $projectModel->getById($id);

        $jobModel = new JobModel($this->getDatabaseConnection());
        $jobs = $jobModel->getByFieldName('project_id', $id);

        $progressSum = 0;
        $jobsCount = count($jobs);
        foreach ($jobs as $value) if (!empty($value->progress)) {
            $progressSum = $progressSum + $value->progress;
        }

        return $this->twig->render('/project_index.html.twig', array(
            'jobs' => $jobs,
            'project' => $project,
            'progressSum' => $progressSum ? $progressSum/$jobsCount : 0,
            'user' => $this->getUser()
        ));
    }

    public function inviteUserToCollaborateForm (Request $request) {

        $id = $request->getParams()[0];

        return $responseView = $this->twig->render('/invite_user_form.html.twig', array(
            'project' => $id
        ));

    }

    public function inviteUserToCollaborate (Request $request) {

        if ($request->getMethod() == 'POST') {

            header('Content-type: application/json');

            $data = $request->getData();
            $data = $data['invite_form'];

            $emailValidator = new EmailValidator();
            $valid = $emailValidator->isValid($data['email']);
            if (!$valid) {
                return json_encode(array(
                    'error' => true,
                    'message' => 'Uneta email adresa nije validna.'
                ));
            }

            $projectModel = new ProjectModel($this->getDatabaseConnection());
            $project = $projectModel->getById($data['project_id']);

            $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
            $userModel = new UserModel($this->getDatabaseConnection());
            $user = $userModel->getOneByFieldName('email', $email);

            if (!$user) {
                $response = array(
                    'error' => true,
                    'message' => 'Korisnik sa navedenom email adresom ne postoji.'
                );
                return json_encode($response);
            }

            $invitationModel = new InvitationModel($this->getDatabaseConnection());
            $invitationData = array(
                'project_id' => $project->id,
                'user_id' => $user->id
            );
            $invitation = $invitationModel->add($invitationData);

            $emailService = new EmailService();
            $subject = "Poziv za ucesce na projektu ".$project->project_name;
            $message = $this->twig->render('/generic/email/invite_user.html.twig', array(
                'user' => $user,
                'project' => $project,
                'project_owner' => $this->getUser(),
                'invitation' => $invitation
            ));
            //$emailService->sendEmail($email, $subject, $message);

            $response = array (
                'error' => false,
                'message' => 'Uspesno ste poslali pozivnicu korisniku '.$user->first_name . ' ' . $user->last_name . ' da se prikljuci projektu.'
            );
            return json_encode($response);
        }
    }

    public function video(Request $request) {
        $id=null;

        if ($request->getMethod() == 'POST') {

            $data = $request->getData();
            $video = false;
            if (array_key_exists("video_url_form", $data)){
                $data = $data['video_url_form'];
                $video = true;
                $url = $data["video_url"];
                preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
                $id = $matches[1];
                $width = '800px';
                $height = '450px';

                return $this->twig->render('/video.html.twig', array(
                    'video' => $video,
                    'id' => $id
                ));
            } else {
                $filename = $data['file_form']['file'];
                $dest = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."project_collaboration".DIRECTORY_SEPARATOR."files".DIRECTORY_SEPARATOR;
                $destination = $dest.$filename;
                if( file_put_contents($filename, $destination) ) {
                    $note = " File uploaded !";
                }else{
                    $note = "Can't upload file.";
                }

                return $this->twig->render('/video.html.twig', array(
                    'video' => $video,
                    'note' => $note,
                    'id' => $id
                ));
            }

        }

        return $this->twig->render('/video.html.twig', array(
            'video' => false,
            'id' => $id
        ));
    }





}