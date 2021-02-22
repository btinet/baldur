<?php


namespace App\Controller;

use App\Entity\Blacklist;
use App\Entity\Room;
use \Btinet\Ringhorn\Controller\AbstractController;


class TimetableController extends AbstractController
{
    /**
     * @param int|null $date_offset
     */
    public function index(int $date_offset = null){

        $roomRepository = $this->getRepository(Room::class);
        $rooms = $roomRepository->findAllJoined('blacklist');

        $currentDateTime = new \DateTime();
        $selectedDateTime = new \DateTime();

        $increaseOffset = $date_offset+1;
        $decreaseOffset = ($date_offset > 0)?$date_offset-1:0;

        $increaseOffset = $this->generateRoute('timetable/index',['dateOffset' => $increaseOffset]);
        $decreaseOffset = $this->generateRoute('timetable/index',['dateOffset' => $decreaseOffset]);

        if(isset($date_offset) && $date_offset > 0){
            $interval = 'P'.$date_offset.'D';
            try {
                $selectedDateTime->add(new \DateInterval($interval));
            } catch (\Exception $e) {
            }
        }

        $timeIntervals = [];
        for($i = 10; $i < 20; $i++){
            $timeIntervals[$i] = new \DateTime();
            $timeIntervals[$i]->setTime($i,0,0);
            if(isset($date_offset) && $date_offset > 0){
                $interval = 'P'.$date_offset.'D';
                try {
                    $timeIntervals[$i]->add(new \DateInterval($interval));
                } catch (\Exception $e) {
                }
            }
        }

        $this->view->render('timetable/index.html.twig',[
            'time' => $timeIntervals,
            'now' => $currentDateTime,
            'selectedDateTime' => $selectedDateTime,
            'increaseOffset' => $increaseOffset,
            'decreaseOffset' => $decreaseOffset,
            'dateOffset' => $date_offset,
            'rooms' => $rooms,
        ]);
    }
}