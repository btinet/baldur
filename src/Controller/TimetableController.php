<?php


namespace App\Controller;

use App\Entity\Room;
use \Btinet\Ringhorn\Controller\AbstractController;
use DateInterval;
use DateTime;


class TimetableController extends AbstractController
{
    /**
     * @param int|null $date_offset
     */
    public function index(int $date_offset = null){

        $roomRepository = $this->getRepository(Room::class);
        $rooms = $roomRepository->findAllJoined('blacklist');

        $currentDateTime = new DateTime();
        $selectedDateTime = new DateTime();

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
                    $timeIntervals[$i]->add(new DateInterval($interval));
                } catch (\Exception $e) {
                }
            }
        }

        $this->view->render('timetable/index.html.twig',[
            'flash' => $this->flash,
            'time' => $timeIntervals,
            'now' => $currentDateTime,
            'selectedDateTime' => $selectedDateTime,
            'increaseOffset' => $increaseOffset,
            'decreaseOffset' => $decreaseOffset,
            'dateOffset' => $date_offset,
            'rooms' => $rooms,
        ]);
    }

    /**
     * @param int $dateOffset
     * @param int $roomId
     * @param string $bookingDate
     */
    public function create_appointment(int $dateOffset,  int $roomId, string $bookingDate){

        if(!$this->getUser()){
            $this->flash->add('Bitte einloggen, um eine Buchung durchzuführen!','warning');
            $this->redirect('302','user/login');
        }

        echo "$dateOffset</br>";
        echo "$roomId</br>";
        echo "$bookingDate</br>";

    }
}