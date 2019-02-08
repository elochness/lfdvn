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

/**
 * @ORM\Entity(repositoryClass="App\Repository\PurchaseConfigRepository")
 */
class PurchaseConfig
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOpenMondayDelivery;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOpenTuesdayDelivery;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOpenWednesdayDelivery;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOpenThursdayDelivery;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOpenFridayDelivery;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOpenSaturdayDelivery;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOpenSundayDelivery;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return PurchaseConfig
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getIsOpenMondayDelivery(): ?bool
    {
        return $this->isOpenMondayDelivery;
    }

    public function setIsOpenMondayDelivery(bool $isOpenMondayDelivery): self
    {
        $this->isOpenMondayDelivery = $isOpenMondayDelivery;

        return $this;
    }

    public function getIsOpenTuesdayDelivery(): ?bool
    {
        return $this->isOpenTuesdayDelivery;
    }

    public function setIsOpenTuesdayDelivery(bool $isOpenTuesdayDelivery): self
    {
        $this->isOpenTuesdayDelivery = $isOpenTuesdayDelivery;

        return $this;
    }

    public function getIsOpenWednesdayDelivery(): ?bool
    {
        return $this->isOpenWednesdayDelivery;
    }

    public function setIsOpenWednesdayDelivery(bool $isOpenWednesdayDelivery): self
    {
        $this->isOpenWednesdayDelivery = $isOpenWednesdayDelivery;

        return $this;
    }

    public function getIsOpenThursdayDelivery(): ?bool
    {
        return $this->isOpenThursdayDelivery;
    }

    public function setIsOpenThursdayDelivery(bool $isOpenThursdayDelivery): self
    {
        $this->isOpenThursdayDelivery = $isOpenThursdayDelivery;

        return $this;
    }

    public function getIsOpenFridayDelivery(): ?bool
    {
        return $this->isOpenFridayDelivery;
    }

    public function setIsOpenFridayDelivery(bool $isOpenFridayDelivery): self
    {
        $this->isOpenFridayDelivery = $isOpenFridayDelivery;

        return $this;
    }

    public function getIsOpenSaturdayDelivery(): ?bool
    {
        return $this->isOpenSaturdayDelivery;
    }

    public function setIsOpenSaturdayDelivery(bool $isOpenSaturdayDelivery): self
    {
        $this->isOpenSaturdayDelivery = $isOpenSaturdayDelivery;

        return $this;
    }

    public function getIsOpenSundayDelivery(): ?bool
    {
        return $this->isOpenSundayDelivery;
    }

    public function setIsOpenSundayDelivery(bool $isOpenSundayDelivery): self
    {
        $this->isOpenSundayDelivery = $isOpenSundayDelivery;

        return $this;
    }
}
