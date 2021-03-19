<?php


namespace App\Controller;


use App\Entity\Room;
use \Btinet\Ringhorn\Controller\AbstractController;


class RoomController extends AbstractController
{

    public function index(){

        $roomRepository = $this->getRepository(Room::class);
        $rooms = $roomRepository->findBy(['isActive' => true]);

        $this->view->render('room/index.html.twig',[
            'rooms' => $rooms,
        ]);
    }

}