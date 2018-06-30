<?php namespace App\src\controllers;

use App\src\core\Request;
use App\src\core\session\FileSessionStorage;
use App\src\core\session\Session;
use App\src\models\UserModel;

class SecurityController extends Controller {

    public function register(Request $request) {

        if (!empty($this->getUser())) {
            $this->redirect('home');
        }

        $errors = array();
        $data = null;

        if ($request->getMethod() == 'POST') {

            $userModel = new UserModel($this->getDatabaseConnection());
            $data = $request->getData()['register_form'];

            if ($data['password_1'] !== $data['password_2']) {
                $errors[] = "Doslo je do greske. Lozinke se ne poklapaju.";
            }

            $user = $userModel->getByFieldName('email', $data['email']);

            if ($user) {
                $errors[] = "Doslo je do greske. Korisnik je vec registrovan .";
            }

            if (empty($errors)) {
                $data['password'] = password_hash($data['password_1'], PASSWORD_DEFAULT);
                unset($data['password_1']);
                unset($data['password_2']);

                $userModel->add($data);

                $this->redirect('register/success');
            }
        }

        return $this->twig->render('/register.html.twig', array(
            'errors' => $errors,
            'data' => $data
        ));
    }

    public function login(Request $request) {

        if (!empty($this->getUser())) {
            $this->redirect('home');
        }

        $errors = array();
        $data = null;

        if ($request->getMethod() == 'POST') {
            $userModel = new UserModel($this->getDatabaseConnection());

            $data = $request->getData()['login_form'];

            $data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
            $data['password'] = filter_var($data['password'], FILTER_SANITIZE_STRING);

            $user = $userModel->getOneByFieldName('email', $data['email']);
            if (!$user) {
                $errors[] = "Korisnik nije pronadjen.";
            } else {
                if (!password_verify($data['password'], $user->password)) {
                    sleep(1);
                    $errors[] = "Uneta lozinka nije ispravna.";
                }
            }

            if (empty($errors)) {
                $this->setSession('user', $user);
                $this->redirect('home', 302);

            }
        }

        return $this->twig->render('/login.html.twig', array(
            'errors' => $errors,
            'data' => $data
        ));
    }

    public function logout() {
        $this->sessionDestroy();
        $this->redirect('login', 302);
    }

    public function registerMessage (Request $request) {
        return $this->twig->render('/register_success.html.twig');
    }

}