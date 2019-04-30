<?php
declare(strict_types = 1);
namespace Controller;

use Core\Validator;
use Core\View;
use Form\LoginForm;
use Form\RegisterForm;
use Models\Users;
use Repository\UserRepository;

class UsersController
{

    private $user;
    private $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->user = new Users();
        $this->userRepository = $userRepository;
    }

    public function defaultAction(): void
    {
        echo 'users default';
    }

    public function addAction(): void
    {
        $register = new RegisterForm();
        $form = $register->getRegisterForm();

        $v = new View('addUser', 'front');
        $v->assign('form', $form);
    }

    /**
     *
     */
    public function saveAction(): void
    {
        $register = new RegisterForm();
        $form = $register->getRegisterForm();
        $method = strtoupper($form['config']['method']);
        $data = $GLOBALS['_'.$method];

        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            $validator = new Validator($form, $data);
            $form['errors'] = $validator->getErrors();

            if (empty($errors)) {
                $this->user->setFirstname($data['firstname']);
                $this->user->setLastname($data['lastname']);
                $this->user->setEmail($data['email']);
                $this->user->setPwd($data['pwd']);
                $this->userRepository->save($this->user);
            }
        }

        $v = new View('addUser', 'front');
        $v->assign('form', $form);
    }

    public function loginAction(): void
    {
        $login = new LoginForm();
        $form = $login->getLoginForm();

        $method = strtoupper($form['config']['method']);
        $data = $GLOBALS['_'.$method];
        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            $validator = new Validator($form, $data);
            $form['errors'] = $validator->getErrors();

            if (empty($errors)) {
                $token = md5(substr(uniqid().time(), 4, 10).'mxu(4il');
                // TODO: connexion
            }
        }

        $v = new View('loginUser', 'front');
        $v->assign('form', $form);
    }

    public function forgetPasswordAction(): void
    {
        $v = new View('forgetPasswordUser', 'front');
    }
}
