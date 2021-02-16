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
     */
    public function index(){

        $categoryRepository = $this->getRepository(Category::class);
        $categories = $categoryRepository->findAll();

        $this->view->render('base/index.html.twig', [
            'flash' => $this->flash,
            'categories' => $categories
        ]);
    }

    /**
     * @meta  route="/new"
     */
    public function new(){

        if ($this->request->isPostRequest() && $this->request->isFormSubmitted()) {

            $category = new Category();
            $em = $this->getEntityManager();

            $category->setTitle($this->request->getQuery('title'));
            $category->setDescription($this->request->getQuery('description'));

            $categoryRepository = $this->getRepository(Category::class);
            $categoryTitleExists = $categoryRepository->findBy([
                'title' => $category->getTitle()
            ]);

            if($categoryTitleExists){

                $this->flash->add('Titel existiert bereits.', 'warning');
                $this->redirect('302', 'base/new');

            } else {

                $em->persist($category);
                $this->flash->add('Eintrag wurde gespeichert!', 'success');
                $this->redirect('302', 'base/index');

            }
        }

        $this->view->render('base/new.html.twig', [
            'session' => $this->session,
            'flash' => $this->flash,
        ]);
    }

    /**
     * @meta  route="/edit"
     * @param int $id
     */
    public function edit(int $id){

        $categoryRepository = $this->getRepository(Category::class);
        $categoryEntry = $categoryRepository->findBy([
            'id' => $id
        ]);

        if(!$categoryEntry){

            $this->flash->add('Eintrag existiert nicht.', 'warning');
            $this->redirect('302', 'base/index');

        } else {

            if ($this->request->isPostRequest() && $this->request->isFormSubmitted()) {

                $category = new Category();
                $em = $this->getEntityManager();

                $category->setTitle($this->request->getQuery('title'));
                $category->setDescription($this->request->getQuery('description'));

                $categoryTitleExists = $categoryRepository->findDuplicate([
                    'title' => $category->getTitle()
                ],
                [
                    'id' => $id
                ]
                );

                if($categoryTitleExists){

                    $this->flash->add('Titel existiert bereits.', 'warning');
                    $this->redirect('302', 'base/edit/'.$id);

                } else {

                    $em->persist($category, $id);
                    $this->flash->add('Eintrag wurde aktualisiert!', 'success');
                    $this->redirect('302', 'base/index');

                }

            }
        }

        $this->view->render('base/edit.html.twig', [
            'session' => $this->session,
            'flash' => $this->flash,
            'category' => array_pop($categoryEntry)
        ]);
    }

    /**
     * @meta  route="/delete"
     * @param int $id
     */
    public function delete(int $id){

        if ($this->request->isPostRequest() && $this->request->isFormSubmitted()) {

            $categoryRepository = $this->getRepository(Category::class);
            $categoryEntry = $categoryRepository->findBy([
                'id' => $id
            ]);

            if(!$categoryEntry){

                $this->flash->add('Eintrag existiert nicht.', 'warning');
                $this->redirect('302', 'base/index');

            } else {

                $category = new Category();
                $em = $this->getEntityManager();
                $em->remove($category, $id);

                $this->flash->add('Eintrag wurde gelöscht!', 'success');
                $this->redirect('302', 'base/index');

            }

        }

        $this->flash->add('Formular ungültig.', 'warning');
        $this->redirect('302', 'base/index');

    }
}
