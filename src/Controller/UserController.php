<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Room;
use App\Entity\User;
use App\Service\PasswordService;
use App\Service\UserService;
use \Btinet\Ringhorn\Controller\AbstractController;

class UserController extends AbstractController
{
    public function index(){
        if(!$this->session->get('login')) $this->redirect(302,'user/login');

        $bookingRepository = $this->getRepository(Booking::class);
        $roomRepository = $this->getRepository(Room::class);

        $userBookings = $bookingRepository->findBy([
            'userId' => $this->session->get('user'),
        ]);
        $rooms = $roomRepository->findAllJoined('blacklist');
        $this->view->render('user/index.html.twig',[
            'flash' => $this->flash,
            'userBookings' => $userBookings,
            'rooms' => $rooms
        ]);
    }

    public function update(string $column){
        if(!$this->session->get('login')) $this->redirect(302,'user/login');
        
        $user = $this->getUser();
        if (!property_exists($user,$column)) {
            $this->flash->add(403,'danger');
            $this->redirect(302,'user/login');
        }
        unset($user->isBlocked);
        if($this->request->isPostRequest() && $this->request->isFormSubmitted()) {

            $userRepository = $this->getRepository(User::class);

            switch($column){
                case 'username':
                    $user->setUsername($this->request->post('username'));
                    if ( 0 === ($isUniqueLastError = UserService::isUnique($userRepository,'username',['username' => $user->getUsername()],21011)) ){
                        unset($user->password);
                        $this->getEntityManager()->persist($user,$this->session->get('user'));
                        $this->flash->add(200);
                        $this->redirect(302,'user/index');
                    } else {
                        $this->flash->add($isUniqueLastError, 'danger');
                    }
                    break;
                case 'email':
                    $user->setEmail($this->request->post('email'));
                    if ( 0 !== ($isEmailLastError = UserService::isEmail('email',['email' => $user->getEmail()],21022)) ) {
                        $this->flash->add($isEmailLastError, 'danger');
                        break;
                    }
                    if ( 0 === ($isUniqueLastError = UserService::isUnique($userRepository,'email',['email' => $user->getEmail()],21012)) ){
                        unset($user->password);
                        $this->getEntityManager()->persist($user,$this->session->get('user'));
                        $this->flash->add(200);
                        $this->redirect(302,'user/index');
                    } else {
                        $this->flash->add($isUniqueLastError, 'danger');
                    }
                    break;
                case 'password':
                    $userInputData = [
                        'username' => $user->getUsername(),
                        'password' => [
                            $this->request->post('password_a'),
                            $this->request->post('password_b'),
                            $this->request->post('password_old'),
                        ],
                    ];
                    if(0 !== $passwordLastError = UserService::isMatch($userRepository,$userInputData)) {
                        $this->flash->add($passwordLastError, 'danger');
                        break;
                    }
                    if(0 != $passwordLastError = PasswordService::validate($userInputData['password'])){
                        $this->flash->add($passwordLastError, 'danger');
                        break;
                    } else {
                        $user->setPassword(array_shift($userInputData['password']));
                        $this->getEntityManager()->persist($user,$this->session->get('user'));
                        $this->flash->add(200);
                        $this->redirect(302,'user/index');
                    }
                    break;
                case 'language':

                    unset($user->password);
                    $user->setLanguage($this->request->post('language'));
                    $this->getEntityManager()->persist($user,$this->session->get('user'));
                    $this->flash->add(200);
                    $this->redirect(302,'user/index');
                    break;
                default:
                    $this->flash->add(403);
                    $this->redirect(302,'user/index');
                    break;
            }
        }

        $this->view->render('user/update.html.twig',[
            'flash' => $this->flash,
            'column' => $column,
            'user' => $user
        ]);
    }

    public function login (){
        if($this->session->get('login')) $this->redirect(302,'user/index');
        $userInputData = 0;
        if($this->request->isPostRequest() && $this->request->isFormSubmitted()) {
            $userInputData = [
                'username' => $this->request->post('username'),
                'password' => $this->request->post('password')
            ];
            $userRepository = $this->getRepository(User::class);
            if(0 === ($tryLoginLastError = UserService::tryLogin($userRepository, $userInputData))){
                $user = $userRepository->findOneBy(['username' => $userInputData['username']]);
                if($user){
                   $this->session->set('user',$user['id']);
                   $this->session->set('login',true);
                }
                $this->flash->add(201);
                $this->redirect(302,'user/index');
            } else {
                $this->flash->add($tryLoginLastError, 'danger');
            }
        }
        $this->view->render('user/login.html.twig',[
            'flash' => $this->flash,
            'user' => $userInputData
        ]);
    }

    public function logout (){
        if($this->session->get('login')){
            $this->session->destroy();
            $this->redirect(302,'user/logout');
        }
        $this->view->render('user/logout.html.twig',[
        ]);
    }

    public function register (){
        if($this->session->get('login')) $this->redirect(302,'user/index');
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
                'isActive' => true,
                'isBlocked' => false,
                'language' => ''
            ];
            $userRepository = $this->getRepository(User::class);
            if(0 === ($validationLastError = UserService::validate($userRepository, $userInputData))){
                $user = new User();
                $user->setUsername($userInputData['username']);
                $user->setEmail($userInputData['email']);
                $user->setPassword($userInputData['password'][0]);
                $user->setFirstname($userInputData['firstname']);
                $user->setLastname($userInputData['lastname']);
                $user->setLanguage($userInputData['language']);
                $this->getEntityManager()->persist($user);
                $this->flash->add(200);
                $this->redirect(302,'user/login');
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
