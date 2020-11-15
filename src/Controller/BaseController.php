<?php

namespace App\Controller;


use App\Entity\Category;
use Btinet\Ringhorn\Controller\AbstractController;

/**
 * @meta route="/base"
 */
class BaseController extends AbstractController
{

    /**
     * @meta  route="/index"
     * @param null $param_1
     * @param null $param_2
     * @param string $method
     */
    public function index(string $method, $param_1 = null, $param_2 = null){

        if ($this->request->isPostRequest() && $this->request->isFormSubmitted()){
            $em = $this->getEntityManager();
            $category = new Category();

            switch ($this->request->getQuery('action')){
                case 'truncate':
                    $result = $em->truncate($category);
                    $this->flash->add("Tabelle $result wurde geleert!", 'danger');
                    break;
                case 'remove':
                    $id = $this->request->getQuery('item');
                    $em->remove($category, $id);
                    $this->flash->add("Eintrag mit der ID $id wurde gelöscht!", 'danger');
                    break;
                default: die('Keine Aktion definiert!');
            }
            $this->redirect('302', 'base/index');
        }

        $categoryRepository = $this->getRepository(Category::class);
        $categories = $categoryRepository->findAll();

        $this->view->render('base/index.html.twig', [
                'controller_name' => 'Übersicht',
                'categories' => $categories,
                'flash' => $this->flash,
                'session' => $this->session
            ]
        );
    }

    public function new(){
        if ($this->request->isPostRequest() && $this->request->isFormSubmitted()){
            $em = $this->getEntityManager();
            $category = new Category();
            $category->setTitle($this->request->getQuery('title'));
            $category->setMeta($this->request->getQuery('meta'));
            $em->persist($category);
            $this->flash->add('Eintrag wurde gespeichert!', 'success');
            $this->redirect('302', 'base/index');
        }
        $this->view->render('base/new.html.twig', [
                'controller_name' => 'Neuer Eintrag',
                'flash' => $this->flash,
                'session' => $this->session
            ]
        );
    }

}
