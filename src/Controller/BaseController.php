<?php

namespace App\Controller;

use Core\Controller\AbstractController;

class BaseController extends AbstractController
{
    function index()
    {
        // TODO: Implement index() method.
        $this->view->render('base.html', [
            'controller_name' => 'BaseController',
            'Title' => 'Vapita Index'
        ]);

    }
}