<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use App\Translation\ErrorTranslation;
use \Btinet\Ringhorn\Controller\AbstractController;

class UserController extends AbstractController
{
    public function index(){
    }

    public function login (){
        $this->view->render('user/login.html.twig',[
            'flash' => $this->flash
        ]);
    }

    public function logout (){
        $this->session->destroy();
        $this->redirect('302','base/index');
    }

    public function register (){
        $userInputData = null;
        if($this->request->isPostRequest() && $this->request->isFormSubmitted()){
            $userInputData = [
                'username' => $this->request->post('username'),
                'email' => $this->request->post('email'),
                'password' => [
                    $this->request->post('password_a'),
                    $this->request->post('password_b'),
                ],
                'firstname' => $this->request->post('firstname'),
                'lastname' => $this->request->post('lastname'),
                'isActive' => true
            ];
            $userRepository = $this->getRepository(User::class);
            if(0 === ($validationLastError = UserService::validate($userRepository, $userInputData))){
                $user = new User($userInputData);
                $this->getEntityManager()->persist($user);
                $this->flash->add(200);
                $this->redirect('302','user/login');
                } else {
                    $this->flash->add($validationLastError, 'danger');
            }
        }
        $this->view->render('user/register.html.twig',[
            'flash' => $this->flash,
            'user' => $userInputData
        ]);
    }
}
