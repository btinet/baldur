<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Core\Controller\AbstractController;

class BaseController extends AbstractController
{

    function index()
    {

        $categoryRepository = new CategoryRepository();
        $category = $categoryRepository->findAll();

        $this->session->set('user', 'bvoigt');

        $password = $this->passwordEncoder->hash("bigben123");
        $password_verified = $this->passwordEncoder->validate("bigben123", $password);

        $this->view->render('base.html.php', [
            'controller_name' => 'BaseController',
            'Title' => 'Vapita Index',
            'user' => $this->session->get('user'),
            'password' => $password,
            'password_verified' => $password_verified,
            'categories' => $category
        ]);

    }
}