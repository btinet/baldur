<?php


namespace App\Controller;

use App\Entity\Booking;
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

        $bookingRepository = $this->getRepository(Booking::class);
        $bookings = $bookingRepository->findBy(['canceled' => 0]);
        $userBookings = $bookingRepository->findBy([
            'userId' => $this->session->get('user'),
        ]);

        $currentDateTime = new DateTime();
        $selectedDateTime = new DateTime();
        $calenderDateTime = new DateTime();

        $increaseOffset = $date_offset+1;
        $decreaseOffset = ($date_offset > 0)?$date_offset-1:0;



        $increaseOffset = $this->generateRoute('timetable/index',['dateOffset' => $increaseOffset],'bookingTable');
        $decreaseOffset = $this->generateRoute('timetable/index',['dateOffset' => $decreaseOffset],'bookingTable');

        if(isset($date_offset) && $date_offset > 0){
            $interval = 'P'.$date_offset.'D';
            try {
                $selectedDateTime->add(new \DateInterval($interval));
                $calenderDateTime->add(new \DateInterval($interval));
            } catch (\Exception $e) {
            }
        }

        $daysCurrentMonth = cal_days_in_month(CAL_GREGORIAN,$calenderDateTime->format('m'),$calenderDateTime->format('y'));
        $currentMonth = $calenderDateTime->format('m');
        $currentYear = $calenderDateTime->format('Y');
        $firstDayCurrentMonth = $calenderDateTime;
        $firstDayCurrentMonth->setDate($currentYear,$currentMonth,1)->format('w');

        $selectedDay = $selectedDateTime;

        if($date_offset >= 0){
            $increaseMonthOffset = $daysCurrentMonth + $date_offset;
            $decreaseMonthOffset = $date_offset - $daysCurrentMonth;
        } else {
            $increaseMonthOffset = $daysCurrentMonth + $date_offset;
            $decreaseMonthOffset = 0;
        }
        if ($currentMonth == $currentDateTime->format('m') ){
            $decreaseMonthOffset = 0;
        }

        $increaseMonthOffsetInt = $increaseMonthOffset;
        $increaseMonthOffset = $this->generateRoute('timetable/index',['dateOffset' => $increaseMonthOffset],'bookingTable');

        $decreaseMonthOffsetInt = $decreaseMonthOffset;
        $decreaseMonthOffset = $this->generateRoute('timetable/index',['dateOffset' => $decreaseMonthOffset],'bookingTable');


        $timeIntervals = [];
        for($i = 6; $i < 22; $i++){
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
            'increaseMonthOffsetInt' => $increaseMonthOffsetInt,
            'increaseMonthOffset' => $increaseMonthOffset,
            'decreaseMonthOffsetInt' => $decreaseMonthOffsetInt,
            'decreaseMonthOffset' => $decreaseMonthOffset,
            'dateOffset' => $date_offset,
            'rooms' => $rooms,
            'bookings' => $bookings,
            'userBookings' => $userBookings,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
            'daysCurrentMonth' => $daysCurrentMonth,
            'firstDayCurrentMonth' => $firstDayCurrentMonth
        ]);
    }
	
	public function bookings(){
		if(!$this->session->get('login')) $this->redirect(302,'user/login');
		
		$bookingRepository = $this->getRepository(Booking::class);
        $roomRepository = $this->getRepository(Room::class);

        $userBookings = $bookingRepository->findBy([
            'userId' => $this->session->get('user'),
        ]);
        $rooms = $roomRepository->findAllJoined('blacklist');       
		
		$this->view->render('timetable/list_booking.html.twig',[
			'flash' => $this->flash,
            'userBookings' => $userBookings,
            'rooms' => $rooms		
		]);
	}

    public function create(){
        if(!$this->session->get('login')) $this->redirect(302,'user/login');

        if($this->request->isFormSubmitted() && $this->request->isPostRequest()){

            $dateOffset = $this->request->post('dateOffset');
            $roomId = $this->request->post('roomId');
            $bookingDate = $this->request->post('bookingDate');

            $currentDateTime = new DateTime('now');

            $roomRepository = $this->getRepository(Room::class);
            $bookingRepository = $this->getRepository(Booking::class);

            $bookingDateTime = DateTime::createFromFormat('Y-m-d H:i:s',$bookingDate);

            $booking = new Booking();

            if (!$room = $roomRepository->findOneBy(['id' => $this->request->post('roomId')])){
                $this->flash->add(1801,'danger');
                $this->redirect(302,"timetable/index/{$dateOffset}");
            }

            if ( $bookingRepository->findOneBy(['appointment' => $bookingDateTime,'roomId' => $roomId,'userId' => $this->session->get('user'),'canceled' => 0])){
                $this->flash->add(1201,'danger');
                $this->redirect(302,"timetable/index/{$dateOffset}");
            }

            if ($bookingDateTime < $currentDateTime){
                $this->flash->add(1202,'danger');
                $this->redirect(302,"timetable/index/{$dateOffset}");
            }

            $booking->setUserId($this->session->get('user'));
            $booking->setCreatedBy($this->session->get('user'));
            $booking->setRoomId($room['id']);
            $booking->setAppointment($bookingDateTime);
            $booking->setTitle($this->request->post('title'));
            $this->getEntityManager()->persist($booking);
            $this->flash->add(200);
            $this->redirect(302,"timetable/index/{$dateOffset}#bookingTable");
        }

        $this->flash->add(403,'danger');
        $this->redirect(302,"timetable/index");

    }

    public function view (){
        if(!$this->session->get('login')) $this->redirect(302,'user/login');
        $user = $this->getUser();

        $bookingRepository = $this->getRepository(Booking::class);
        $userBookings = $bookingRepository->findBy([
            'userId' => $this->session->get('user')
        ]);

        print_r($userBookings);

    }
	
	public function delete(int $id){
		if(!$this->session->get('login')) $this->redirect(302,'user/login');
		
		if($this->request->isFormSubmitted() && $this->request->isPostRequest()){
			
			$bookingRepository = $this->getRepository(Booking::class);
			$userBooking = $bookingRepository->findOneBy([
				'id' => $id,
				'userId' => $this->session->get('user')	,
                'canceled' => false
			]);
			
			if($userBooking){

			    $booking = new Booking();
			    $booking->setUpdatedBy($this->session->get('user'));
			    $booking->setCanceled(true);

				$this->getEntityManager()->persist($booking,$id);
				$this->flash->add(1204);
				$this->redirect('302', 'timetable/bookings');
			} else {
				$this->flash->add(1205,'danger');
				$this->redirect('302', 'timetable/bookings');
			}		
			
		}
		
		$this->redirect('302', 'timetable/bookings');
	}
	
}
