<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VatRate
 *
 * @ORM\Table(name="vat_rate")
 * @ORM\Entity
 */
class VatRate
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="rate", type="float", precision=10, scale=0, nullable=false)
     */
    private $rate;


}
