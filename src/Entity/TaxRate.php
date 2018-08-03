<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaxRate
 *
 * @ORM\Table(name="tax_rate")
 * @ORM\Entity
 */
class TaxRate
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

    /**
     * Get id
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * get rate
     * @return float|null
     */
    public function getRate(): ?float
    {
        return $this->rate;
    }

    /**
     * set rate
     * @param float $rate
     * @return TaxRate
     */
    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get String information of TaxRate
     *
     * @return string Name of TaxRate
     */
    public function __toString(): string
    {
        return strval($this->getRate()) . " %";
    }

}
