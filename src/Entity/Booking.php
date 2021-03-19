<?php


namespace App\Entity;


use DateTime;

class Booking
{

    /**
     * @var string|null
     */
    public string $title;

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
     * @var bool
     */
    public bool $canceled;

    /**
     * @var DateTime
     */
    public DateTime $created;

    /**
     * @var int
     */
    public int $createdBy;

    /**
     * @var DateTime
     */
    public DateTime $updated;

    /**
     * @var int
     */
    public int $updatedBy;


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title):void
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
     * @return bool
     */
    public function getCanceled(): bool
    {
        return $this->canceled;
    }

    /**
     * @param bool $canceled
     */
    public function setCanceled(bool $canceled): void
    {
        $this->canceled = $canceled;
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

    /**
     * @return int
     */
    public function getCreatedBy(): int
    {
        return $this->createdBy;
    }

    /**
     * @param int $createdBy
     */
    public function setCreatedBy(int $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return int
     */
    public function getUpdatedBy(): int
    {
        return $this->updatedBy;
    }

    /**
     * @param int $updatedBy
     */
    public function setUpdatedBy(int $updatedBy): void
    {
        $this->updatedBy = $updatedBy;
    }

}
