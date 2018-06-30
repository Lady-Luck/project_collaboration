<?php namespace App\src\controllers;

use App\src\core\Request;
use App\src\models\CommentModel;
use App\src\models\JobModel;
use App\src\models\JobUserModel;
use App\src\models\ProjectModel;
use App\src\models\UserModel;

class JobController extends Controller {

    public function newJob (Request $request) {

        $projectId = $request->getParams()[0];
        $projectModel = new ProjectModel($this->getDatabaseConnection());
        $project = $projectModel->getById($projectId);

        if ($request->getMethod() == 'POST') {
            $data = $request->getData()['job_form'];

            $jobModel = new JobModel($this->getDatabaseConnection());
            $data['user_id'] = $this->getUser()->user_id;
            $data['project_id'] = $project->project_id;
            $jobModel->add($data);

            $this->redirect(BASE_URL . '/project/'.$project->project_id);
        }

        return $this->twig->render('/job.html.twig', array(
            'user' => $this->getUser(),
            'project' => $project
        ));
    }

    public function applyToJob (Request $request) {
        $user = $this->getUser();
        if (!$user) {
            $this->redirect('/login');
        }

        $jobId = $request->getParams()[0];
        $jobModel = new JobModel($this->getDatabaseConnection());
        $job = $jobModel->getById($jobId);

        if ($request->getMethod() == 'POST') {

            header('Content-type: application/json');
            $response = null;

            $data = $request->getData()['job_apply'];
            $data['user_id'] = $user->user_id;
            $data['job_id']  = $jobId;

            $jobUserModel = new JobUserModel($this->getDatabaseConnection());
            $success = $jobUserModel->insertToDb($data);

            if ($success) {
                $response = array (
                    'error' => false,
                    'message' => 'Uspesno ste se prijavili za posao.'
                );
            } else {
                $response = array (
                    'error' => true,
                    'message' => 'Doslo je do greske. Molimo, pokusajte kasnije.'
                );
            }
            return json_encode($response);
        }

        return $this->twig->render('/job_apply.html.twig', array(
            'user' => $user,
            'job' => $job
        ));

    }

    public function view(Request $request) {

        $jobId = $request->getParams()[0];
        $jobModel = new JobModel($this->getDatabaseConnection());
        $job = $jobModel->getById($jobId);

        $commentModel = new CommentModel($this->getDatabaseConnection());
        $userModel = new UserModel($this->getDatabaseConnection());

        $comments = $commentModel->getCommentsForJob($jobId);

        if ($comments) {

            foreach ($comments as $key => $comment) {
                $user = null;
                $user = $userModel->getById($comment['user_id']);
                $comments[$key]['user'] = $user;
            }

        }

        return $this->twig->render('/job/job_view.html.twig', array(
            'user' => $this->getUser(),
            'job' => $job,
            'comments' => $comments
        ));
    }

}