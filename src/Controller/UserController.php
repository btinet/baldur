<?php


namespace App\Controller;


use App\Entity\User;
use \Btinet\Ringhorn\Controller\AbstractController;


class UserController extends AbstractController
{

    public function index(){
        if($this->getUser()){
            $this->redirect('302','base/index');
        } else {
            $this->redirect('302','user/login');
        }
    }

    public function login (){
        if($this->getUser()){
            $this->redirect('302','base/index');
        }

        $this->view->render('user/login.html.twig',[
            'flash' => $this->flash
        ]);
    }

    public function logout (){
        if(!$this->getUser()){
            $this->redirect('302','base/index');
        }
        $this->session->destroy();
        $this->redirect('302','base/index');
    }

    public function register (){

        if($this->getUser()){
            $this->redirect('302','base/index');
        }

        $userData = null;

        if($this->request->isPostRequest() && $this->request->isFormSubmitted()){

            $userRepository = $this->getRepository(User::class);
            $userData = [
                'username' => $this->request->getQuery('username'),
                'email' => $this->request->getQuery('email'),
                'password' => [
                    $this->request->getQuery('password_a'),
                    $this->request->getQuery('password_b'),
                ],
                'firstname' => $this->request->getQuery('firstname'),
                'lastname' => $this->request->getQuery('lastname'),
            ];

            $user = $this->user->validate(new User(),$userRepository,$userData);

            if(is_object($user)) {
                $em = $this->getEntityManager();
                $em->persist($user);
                $this->flash->add(200);
                $this->redirect('302','user/login');
            }  else {
                $this->flash->add($user,'danger');
            }
        }

        $this->view->render('user/register.html.twig',[
            'flash' => $this->flash,
            'user' => $userData
        ]);

    }
}
