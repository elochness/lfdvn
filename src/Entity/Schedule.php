<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Schedule
 *
 * @ORM\Table(name="schedule")
 * @ORM\Entity
 */
class Schedule
{

    /**
     * Indicate the day is closed.
     * @TODO Make a translation
     * @var string
     */
    const CLOSED_DAY = 'Fermé';

    /**
     * Schedule ID
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * Monday Opening Hours
     * @var string
     *
     * @ORM\Column(name="monday", type="string", length=30, nullable=false)
     */
    private $monday;

    /**
     * Tuesday Opening Hours
     * @var string
     *
     * @ORM\Column(name="tuesday", type="string", length=30, nullable=false)
     */
    private $tuesday;

    /**
     * Wednesday Opening Hours
     * @var string
     *
     * @ORM\Column(name="wednesday", type="string", length=30, nullable=false)
     */
    private $wednesday;

    /**
     * Thursday Opening Hours
     * @var string
     *
     * @ORM\Column(name="thursday", type="string", length=30, nullable=false)
     */
    private $thursday;

    /**
     * Friday Opening Hours
     * @var string
     *
     * @ORM\Column(name="friday", type="string", length=30, nullable=false)
     */
    private $friday;

    /**
     * Saturday Opening Hours
     * @var string
     *
     * @ORM\Column(name="saturday", type="string", length=30, nullable=false)
     */
    private $saturday;

    /**
     * Sunday Opening Hours
     * @var string
     *
     * @ORM\Column(name="sunday", type="string", length=30, nullable=false)
     */
    private $sunday;

    /**
     * Alert of the day
     * @var string
     *
     * @ORM\Column(name="alert_day", type="string", length=255, nullable=false)
     */
    private $alertDay;

    /**
     * Get schedule ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set schedule ID
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Get Monday Opening Hours
     * @return string
     */
    public function getMonday(): string
    {
        return $this->monday;
    }

    /**
     * Set Monday Opening Hours
     * @param string $monday
     */
    public function setMonday(string $monday): void
    {
        $this->monday = $monday;
    }

    /**
     * Get Tuesday Opening Hours
     * @return string
     */
    public function getTuesday(): string
    {
        return $this->tuesday;
    }

    /**
     * Set Tuesday Opening Hours
     * @param string $tuesday
     */
    public function setTuesday(string $tuesday): void
    {
        $this->tuesday = $tuesday;
    }

    /**
     * Get Wednesday Opening Hours
     * @return string
     */
    public function getWednesday(): string
    {
        return $this->wednesday;
    }

    /**
     * Set Wednesday Opening Hours
     * @param string $wednesday
     */
    public function setWednesday(string $wednesday): void
    {
        $this->wednesday = $wednesday;
    }

    /**
     * Get Thursday Opening Hours
     * @return string
     */
    public function getThursday(): string
    {
        return $this->thursday;
    }

    /**
     * Set Thursday Opening Hours
     * @param string $thursday
     */
    public function setThursday(string $thursday): void
    {
        $this->thursday = $thursday;
    }

    /**
     * Get Friday Opening Hours
     * @return string
     */
    public function getFriday(): string
    {
        return $this->friday;
    }

    /**
     * Set Friday Opening Hours
     * @param string $friday
     */
    public function setFriday(string $friday): void
    {
        $this->friday = $friday;
    }

    /**
     * Get Saturday Opening Hours
     * @return string
     */
    public function getSaturday(): string
    {
        return $this->saturday;
    }

    /**
     * Set Saturday Opening Hours
     * @param string $saturday
     */
    public function setSaturday(string $saturday): void
    {
        $this->saturday = $saturday;
    }

    /**
     * Get Sunday Opening Hours
     * @return string
     */
    public function getSunday(): string
    {
        return $this->sunday;
    }

    /**
     * Set Sunday Opening Hours
     * @param string $sunday
     */
    public function setSunday(string $sunday): void
    {
        $this->sunday = $sunday;
    }

    /**
     * Get alert of the day
     * @return string
     */
    public function getAlertDay(): string
    {
        return $this->alertDay;
    }

    /**
     * Set alert of the day
     * @param string $alertDay
     */
    public function setAlertDay(string $alertDay): void
    {
        $this->alertDay = $alertDay;
    }

}
