<?php


namespace App\Entity;


use DateTime;

class Booking
{

    /**
     * @var string|null
     */
    public string|null $title;

    /**
     * @var int
     */
    public int $roomId;

    /**
     * @var int
     */
    public int $userId;

    /**
     * @var DateTime
     */
    public Datetime $appointment;

    /**
     * @var DateTime
     */
    public DateTime $created;

    /**
     * @var DateTime
     */
    public DateTime $updated;

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getRoomId(): int
    {
        return $this->roomId;
    }

    /**
     * @param int $roomId
     */
    public function setRoomId(int $roomId): void
    {
        $this->roomId = $roomId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return DateTime
     */
    public function getAppointment(): DateTime
    {
        return $this->appointment;
    }

    /**
     * @param DateTime $appointment
     */
    public function setAppointment(DateTime $appointment): void
    {
        $this->appointment = $appointment;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

}
