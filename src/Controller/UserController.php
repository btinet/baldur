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
            $newUser = new User();
            $userRepository = $this->getRepository(User::class);

            $userData['username'] = $this->request->getQuery('username');
            $userData['email'] = $this->request->getQuery('email');
            $userData['password'] = $this->request->getQuery('password');
            $userData['password_check'] = $this->request->getQuery('password_check');
            $userData['firstname'] = $this->request->getQuery('firstname');
            $userData['lastname'] = $this->request->getQuery('lastname');

            do{

                $username = $this->request->getQuery('username');
                if(is_string($username)){
                    $usernameExists = $userRepository->findOneBy(['username' => $username]);
                    if($usernameExists){
                        $this->flash->add('Benutzername existiert bereits!','danger');
                        break;
                    }
                    $newUser->setUsername($username);
                } else {
                    $this->flash->add('Benutzername ist nicht konform!','danger');
                    break;
                }

                $email = $this->request->getQuery('email');
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $emailExists = $userRepository->findOneBy(['email' => $email]);
                    if($emailExists){
                        $this->flash->add('Email-Adresse existiert bereits!','danger');
                        break;
                    }
                    $newUser->setEmail($email);
                } else {
                    $this->flash->add('Email-Adresse ist nicht konform!','danger');
                    break;
                }

                $password = $this->request->getQuery('password');
                $passwordCheck = $this->request->getQuery('password_check');
                if($password == $passwordCheck){
                    $passwordHashed = $this->passwordEncoder->hash($password);
                    $newUser->setPassword($passwordHashed);
                } else {
                    $this->flash->add('Die Passwörter stimmen nicht überein!','danger');
                    break;
                }

                $firstname = $this->request->getQuery('firstname');
                if(is_string($firstname)){
                    $newUser->setFirstname($firstname);

                } else {
                    $this->flash->add('Vorname ist nicht konform!','danger');
                    break;
                }

                $lastname = $this->request->getQuery('lastname');
                if(is_string($lastname)){
                    $newUser->setLastname($lastname);
                } else {
                    $this->flash->add('Nachname ist nicht konform!','danger');
                    break;
                }

                $newUser->setIsActive(1);
                $newUser->setIsBlocked(0);

                $em = $this->getEntityManager();
                $em->persist($newUser);

                $this->flash->add('Benutzer wurde erfolgreich gespeichert','success');

                $this->redirect('302','user/login');
            }while(false);
        }

        $this->view->render('user/register.html.twig',[
            'flash' => $this->flash,
            'user' => $userData
        ]);

    }
}
