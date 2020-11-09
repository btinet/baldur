<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Core\Controller\AbstractController;
use Core\Logger;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class BaseController extends AbstractController
{

    function index()
    {

        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->findAll();

        $this->session->set('user', 'bvoigt');

        $password = $this->passwordEncoder->hash("bigben123");
        $password_verified = $this->passwordEncoder->validate("bigben123", $password);

        // Template Laden

        try {
            echo $this->view->render('base/index.html.twig', [
                    'controller_name' => 'BaseController',
                    'categories' => $categories
                ]
            );
        } catch (LoaderError $e) {
            Logger::newMessage($e);
            Logger::customErrorMsg($e);
        } catch (RuntimeError $e) {
            Logger::newMessage($e);
            Logger::customErrorMsg($e);
        } catch (SyntaxError $e) {
            Logger::newMessage($e);
            Logger::customErrorMsg($e);
        }
    }
}