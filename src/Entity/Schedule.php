<?php

/*
 * This file is part of the lfdvn package.
 *
 * (c) Pierre François
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Schedule.
 *
 * @ORM\Table(name="schedule")
 * @ORM\Entity
 */
class Schedule
{
    /** @TODO Make a translation */
    /**
     * Indicate the day is close.
     *
     * @var string
     */
    const CLOSED_DAY = 'Fermé';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="monday", type="string", length=30, nullable=false)
     */
    private $monday;

    /**
     * @var string
     *
     * @ORM\Column(name="tuesday", type="string", length=30, nullable=false)
     */
    private $tuesday;

    /**
     * @var string
     *
     * @ORM\Column(name="wednesday", type="string", length=30, nullable=false)
     */
    private $wednesday;

    /**
     * @var string
     *
     * @ORM\Column(name="thursday", type="string", length=30, nullable=false)
     */
    private $thursday;

    /**
     * @var string
     *
     * @ORM\Column(name="friday", type="string", length=30, nullable=false)
     */
    private $friday;

    /**
     * @var string
     *
     * @ORM\Column(name="saturday", type="string", length=30, nullable=false)
     */
    private $saturday;

    /**
     * @var string
     *
     * @ORM\Column(name="sunday", type="string", length=30, nullable=false)
     */
    private $sunday;

    /**
     * @var string
     *
     * @ORM\Column(name="alert_day", type="string", length=255, nullable=false)
     */
    private $alertDay;

    /**
     * Get id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return Schedule
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get monday.
     *
     * @return string|null
     */
    public function getMonday(): ?string
    {
        return $this->monday;
    }

    /**
     * Set monday.
     *
     * @param string $monday
     *
     * @return Schedule
     */
    public function setMonday(string $monday): self
    {
        $this->monday = $monday;

        return $this;
    }

    /**
     * Get tuesday.
     *
     * @return string|null
     */
    public function getTuesday(): ?string
    {
        return $this->tuesday;
    }

    /**
     * Set tuesday.
     *
     * @param string $tuesday
     *
     * @return Schedule
     */
    public function setTuesday(string $tuesday): self
    {
        $this->tuesday = $tuesday;

        return $this;
    }

    /**
     * Get wednesday.
     *
     * @return string|null
     */
    public function getWednesday(): ?string
    {
        return $this->wednesday;
    }

    /**
     * Set wednesday.
     *
     * @param string $wednesday
     *
     * @return Schedule
     */
    public function setWednesday(string $wednesday): self
    {
        $this->wednesday = $wednesday;

        return $this;
    }

    /**
     * Get thursday.
     *
     * @return string|null
     */
    public function getThursday(): ?string
    {
        return $this->thursday;
    }

    /**
     * Set thursday.
     *
     * @param string $thursday
     *
     * @return Schedule
     */
    public function setThursday(string $thursday): self
    {
        $this->thursday = $thursday;

        return $this;
    }

    /**
     * Get friday.
     *
     * @return string|null
     */
    public function getFriday(): ?string
    {
        return $this->friday;
    }

    /**
     * Set friday.
     *
     * @param string $friday
     *
     * @return Schedule
     */
    public function setFriday(string $friday): self
    {
        $this->friday = $friday;

        return $this;
    }

    /**
     * Get saturday.
     *
     * @return string|null
     */
    public function getSaturday(): ?string
    {
        return $this->saturday;
    }

    /**
     * Set saturday.
     *
     * @param string $saturday
     *
     * @return Schedule
     */
    public function setSaturday(string $saturday): self
    {
        $this->saturday = $saturday;

        return $this;
    }

    /**
     * Get sunday.
     *
     * @return string|null
     */
    public function getSunday(): ?string
    {
        return $this->sunday;
    }

    /**
     * Set sunday.
     *
     * @param string $sunday
     *
     * @return Schedule
     */
    public function setSunday(string $sunday): self
    {
        $this->sunday = $sunday;

        return $this;
    }

    /**
     * Get alertDay.
     *
     * @return string|null
     */
    public function getAlertDay(): ?string
    {
        return $this->alertDay;
    }

    /**
     * Set alertDay.
     *
     * @param string $alertDay
     *
     * @return Schedule
     */
    public function setAlertDay(string $alertDay): self
    {
        $this->alertDay = $alertDay;

        return $this;
    }

    /**
     * Get day formatted by datetime.
     *
     * @param $date
     * @param TranslatorInterface $translator
     *
     * @return string
     */
    public static function getDayFormatted(string $date, TranslatorInterface $translator): string
    {
        $dayNumberOfWeek = date('N', strtotime($date));
        $stringDay = '';
        // Day
        if (1 === $dayNumberOfWeek) {
            $stringDay = $translator->trans('Monday');
        } elseif (2 === $dayNumberOfWeek) {
            $stringDay = $translator->trans('Tuesday');
        } elseif (3 === $dayNumberOfWeek) {
            $stringDay = $translator->trans('Wednesday');
        } elseif (4 === $dayNumberOfWeek) {
            $stringDay = $translator->trans('Thursday');
        } elseif (5 === $dayNumberOfWeek) {
            $stringDay = $translator->trans('Friday');
        } elseif (6 === $dayNumberOfWeek) {
            $stringDay = $translator->trans('Saturday');
        } elseif (7 === $dayNumberOfWeek) {
            $stringDay = $translator->trans('Sunday');
        }

        return $stringDay;
    }

    /**
     * Get month formatted by datetime.
     *
     * @param string              $date
     * @param TranslatorInterface $translator
     *
     * @return string
     */
    public static function getMonthFormatted(string $date, TranslatorInterface $translator): string
    {
        $monthNumber = date('m', strtotime($date));
        $stringMonth = '';

        if (1 === $monthNumber) {
            $stringMonth = $translator->trans('january');
        } elseif (2 === $monthNumber) {
            $stringMonth = $translator->trans('february');
        } elseif (3 === $monthNumber) {
            $stringMonth = $translator->trans('march');
        } elseif (4 === $monthNumber) {
            $stringMonth = $translator->trans('april');
        } elseif (5 === $monthNumber) {
            $stringMonth = $translator->trans('may');
        } elseif (6 === $monthNumber) {
            $stringMonth = $translator->trans('june');
        } elseif (7 === $monthNumber) {
            $stringMonth = $translator->trans('july');
        } elseif (8 === $monthNumber) {
            $stringMonth = $translator->trans('august');
        } elseif (9 === $monthNumber) {
            $stringMonth = $translator->trans('september');
        } elseif (10 === $monthNumber) {
            $stringMonth = $translator->trans('october');
        } elseif (11 === $monthNumber) {
            $stringMonth = $translator->trans('november');
        } elseif (12 === $monthNumber) {
            $stringMonth = $translator->trans('december');
        }

        return $stringMonth;
    }
}
