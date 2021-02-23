<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Category;
use App\Repository\CategoryRepository;
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

        $user = $this->getUser();
        if ($user){
            $userSession['roles'] = $user->getRoles(true);
            $this->session->set('user',$userSession);
            $this->security->denyAccessUntilGranted('ROLE_USER');
        }

        $categoryRepository = $this->getRepository(Category::class);
        $categories = $categoryRepository->findAllAndParentAsArray();

        $this->view->render('base/index.html.twig', [
            'flash' => $this->flash,
            'categories' => $categories,
            ]);
    }

    /**
     * @meta  route="/view"
     * @param int|null $id
     */
    public function view(int $id = null){

        $categoryRepository = $this->getRepository(Category::class);
        $category = $categoryRepository->findOneBy([
            'id' => $id
        ]);
        $categories = $categoryRepository->findAllAndParentAsArray();
        $previous = $categoryRepository->getPrevious($id);
        $next = $categoryRepository->getNext($id);

        $this->view->render('base/view.html.twig', [
            'session' => $this->session,
            'entry' => $category,
            'categories' => $categories,
            'previous' => $previous,
            'next' => $next
        ]);
    }

    /**
     * @meta  route="/new"
     */
    public function new(){

        $categoryRepository = $this->getRepository(Category::class);
        $categories = $categoryRepository->findAll();

        if ($this->request->isPostRequest() && $this->request->isFormSubmitted()) {

            $category = new Category();
            $em = $this->getEntityManager();


            $category->setParent($this->request->getQuery('parent'));
            $category->setTitle($this->request->getQuery('title'));
            $category->setDescription($this->request->getQuery('description'));


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
            'categories' => $categories
        ]);
    }

    /**
     * @meta  route="/edit"
     * @param int $id
     */
    public function edit(int $id){

        $categoryRepository = $this->getRepository(Category::class);
        $categories = $categoryRepository->findAll();
        $categoryEntry = $categoryRepository->findBy([
            'id' => $id
        ]);

        $previous = $categoryRepository->getPrevious($id);
        $next = $categoryRepository->getNext($id);

        if(!$categoryEntry){

            $this->flash->add('Eintrag existiert nicht.', 'warning');
            $this->redirect('302', 'base/index');

        } else {

            if ($this->request->isPostRequest() && $this->request->isFormSubmitted()) {

                $category = new Category();
                $em = $this->getEntityManager();

                $category->setParent($this->request->getQuery('parent'));
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
            'category' => array_pop($categoryEntry),
            'categories' => $categories,
            'previous' => $previous,
            'next' => $next
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

        $this->redirect('302', 'base/index');
    }

    /**
     * @meta  route="/truncate"
     */
    public function truncate(){

        if ($this->request->isPostRequest() && $this->request->isFormSubmitted()) {

            $category = new Category();
            $em = $this->getEntityManager();

            $em->truncate($category);

            $this->flash->add('Tabelle wurde geleert!', 'success');

        }

        $this->redirect('302', 'base/index');
    }
}
