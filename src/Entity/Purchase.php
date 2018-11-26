<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Purchase
 *
 * @ORM\Table(name="purchase", indexes={@ORM\Index(name="IDX_6117D13B6C755722", columns={"buyer_id"})})
 * @ORM\Entity
 */
class Purchase
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
     * @var \DateTime
     *
     * @ORM\Column(name="delivery_date", type="date", nullable=false)
     */
    private $deliveryDate;

    /**
     * Delivery date formatted
     *
     * @var string
     */
    private $deliveryDateFormatted;


    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="purchases", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="buyer_id", referencedColumnName="id")
     * })
     */
    private $buyer;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="PurchaseItem", mappedBy="purchase", cascade={"persist"})
     */
    private $items;

    /**
     * Constructor of the Purchase class.
     * (Initialize some fields).
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->deliveryDate = new \DateTime();
        $this->items = new ArrayCollection();
    }

    /**
     * Get id
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get deliveryDate
     * @return \DateTimeInterface|null
     */
    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    /**
     * Set deliveryDate
     * @param \DateTimeInterface $deliveryDate
     * @return Purchase
     */
    public function setDeliveryDate(\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    /**
     * Get deliveryDateFormatted
     * @return string
     */
    public function getDeliveryDateFormatted(): string
    {
        return $this->deliveryDateFormatted;
    }

    /**
     * Set deliveryDateFormatted
     * @param string $deliveryDateFormatted
     * @return Purchase
     */
    public function setDeliveryDateFormatted(string $deliveryDateFormatted): self
    {
        $this->deliveryDateFormatted = $deliveryDateFormatted;

        return $this;
    }

    /**
     * Get comment
     * @return null|string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Set comment
     * @param null|string $comment
     * @return Purchase
     */
    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get createdAt
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     * @param \DateTimeInterface $createdAt
     * @return Purchase
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get buyer
     * @return User|null
     */
    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    /**
     * Set buyer
     * @param User|null $buyer
     * @return Purchase
     */
    public function setBuyer(?User $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    /**
     * Add item
     *
     * @param PurchaseItem $item
     *
     * @return Purchase
     */
    public function addItem(PurchaseItem $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param PurchaseItem $item
     *
     * @return Purchase
     */
    public function removeItem(PurchaseItem $item): self
    {
        $this->items->removeElement($item);

        return $this;
    }

    /**
     * Get items
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems(): \Doctrine\Common\Collections\Collection
    {
        return $this->items;
    }

    /**
     * Get String information of purchase
     *
     * @return string Name of purchase
     */
    public function __toString(): string
    {
        return $this->getId() . " - " . $this->getCreatedAt();
    }

}
