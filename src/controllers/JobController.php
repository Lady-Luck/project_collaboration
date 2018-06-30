<?php namespace App\src\controllers;

use App\src\core\Request;
use App\src\models\JobModel;
use App\src\models\ProjectModel;

class JobController extends Controller {

    public function newJob (Request $request) {

        $projectId = $request->getParams()[0];
        $projectModel = new ProjectModel($this->getDatabaseConnection());
        $project = $projectModel->getById($projectId);

        if ($request->getMethod() == 'POST') {
            $data = $request->getData()['job_form'];

            $jobModel = new JobModel($this->getDatabaseConnection());
            $jobModel->add($data);

            $this->redirect('/project_collaboration/project/'.$project->id);
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

            $success = $jobModel->applyToJob($user->id, $jobId);
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








}