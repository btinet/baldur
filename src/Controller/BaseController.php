<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Core\Controller\AbstractController;
use Exception;

/**
 * @meta route="/base"
 */
class BaseController extends AbstractController
{

    /**
     * @meta  route="/index"
     */
    function index()
    {

        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->findAll();

        if ($this->request->isPostRequest() && $this->request->isFormSubmitted()){
            $user = $this->request->getQuery('user');
            $this->flash->add('Cool, ja, es hat geklappt, mein(e) liebe(r) '. $user, 'success');
        }

        $this->session->set('user', 'bvoigt');

        $password = $this->passwordEncoder->hash("bigben123");
        $password_verified = $this->passwordEncoder->validate("bigben123", $password);


        $this->view->render('base/index.html.twig', [
                'controller_name' => 'BaseController',
                'categories' => $categories,
                'flash' => $this->flash,
                'session' => $this->session
            ]
        );

    }
}