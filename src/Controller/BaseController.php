<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Core\Controller\AbstractController;

class BaseController extends AbstractController
{
    function index()
    {

        $categoryRepository = new CategoryRepository();
        //$category = $categoryRepository->findAll();

        $this->session->set('user', 'bvoigt');
        $password = password_hash("bigben123", PASSWORD_DEFAULT);

        $this->view->render('base.html.php', [
            'controller_name' => 'BaseController',
            'Title' => 'Vapita Index',
            'user' => $this->session->get('user'),
            'password' => $password
        ]);

    }
}