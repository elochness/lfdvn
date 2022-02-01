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
     * VAT Rate ID
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * VAT rate
     * @var float
     *
     * @ORM\Column(name="rate", type="float", precision=10, scale=0, nullable=false)
     */
    private $rate;

    /**
     * Get VAT rate ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get rate of VAT
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * Set rate of VAT
     * @param float $rate
     */
    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * Get information of TaxRate.
     * @return string VAT rate
     */
    public function __toString(): string
    {
        return ($this->getRate()*100) . '%';
    }
}
