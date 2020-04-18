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


}
