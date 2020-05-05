<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ProductOrder
 *
 * @ORM\Table(name="product_order", indexes={@ORM\Index(name="IDX_user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class ProductOrder
{
    /**
     * Product Order ID
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Delivery date of the product order
     * @var DateTime
     *
     * @ORM\Column(name="delivery_date", type="date", nullable=false)
     */
    private $deliveryDate;

    /**
     * Comment of the product order
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=true)
     */
    private $comment;

    /**
     * Product order creation date
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * User of the product order
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


    /**
     * Items of product order
     * @var Collection
     * @ORM\OneToMany(targetEntity="ProductOrderItem", mappedBy="productOrder", cascade={"persist"})
     */
    private $items;

    /**
     * ProductOrder constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * Get Product order ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get delivery date of the product order
     * @return DateTime
     */
    public function getDeliveryDate(): DateTime
    {
        return $this->deliveryDate;
    }

    /**
     * Set delivery date of the product order
     * @param DateTime $deliveryDate
     */
    public function setDeliveryDate(DateTime $deliveryDate): void
    {
        $this->deliveryDate = $deliveryDate;
    }

    /**
     * Get comment of the product order
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Set comment of the product order
     * @param string|null $comment
     */
    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * Get product order creation date
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set product order creation date
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get user of the product order
     * @return \User
     */
    public function getUser(): \User
    {
        return $this->user;
    }

    /**
     * Set user of the product order
     * @param \User $user
     */
    public function setUser(\User $user): void
    {
        $this->user = $user;
    }

    /**
     * Get items of the product order
     * @return Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * Set user items of the product order
     * @param Collection $items
     */
    public function setItems(Collection $items): void
    {
        $this->items = $items;
    }

    /**
     * Add an item of the product order
     * @param ProductOrderItem $item
     */
    public function addItem(ProductOrderItem $item): void
    {
        $this->items[] = $item;
    }

    /**
     * Remove item of the product order
     * @param ProductOrderItem $item
     */
    public function removeItem(ProductOrderItem $item): void
    {
        $this->items->removeElement($item);
    }

    /**
     * Get information of the product order.
     * @return string Name of purchase
     */
    public function __toString(): string
    {
        return $this->id.' - '.$this->createdAt;
    }

    /**
     * Get full price of the product order
     * @return float
     */
    public function getFullPrice()
    {
        $total = 0.0;
        foreach ($this->getItems() as $item) {
            /* @var ProductOrderItem $item */
            $total += $item->getTotalPrice();
        }

        return $total;
    }
}
