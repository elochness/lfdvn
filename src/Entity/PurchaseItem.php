<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PurchaseItem
 *
 * @ORM\Table(name="purchase_item", indexes={@ORM\Index(name="IDX_6FA8ED7D4584665A", columns={"product_id"}), @ORM\Index(name="IDX_6FA8ED7D558FBEB9", columns={"purchase_id"})})
 * @ORM\Entity
 */
class PurchaseItem
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
     * @var int
     *
     * @ORM\Column(name="quantity", type="smallint", nullable=false)
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="tax_rate", type="float", precision=10, scale=0, nullable=false)
     */
    private $taxRate;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var Purchase
     *
     * @ORM\ManyToOne(targetEntity="Purchase", inversedBy="items", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="purchase_id", referencedColumnName="id")
     * })
     */
    private $purchase;

    /**
     * Get String information of purchase item
     *
     * @return string purchase item
     */
    public function __toString()
    {
        if (isset($this->product)) {
            if ($this->quantity > 0) {
                return $this->product->getName() .' [x'.$this->getQuantity().']: '.$this->getTotalPrice();
            } else {
                return $this->product->getName();
            }
        } else {
            // TODO change string in constant
            return "Non défini";
        }
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
     * Get quantity
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * Set quantity
     * @param int $quantity
     * @return PurchaseItem
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get price
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * Set price
     * @param float $price
     * @return PurchaseItem
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get taxRate
     * @return float|null
     */
    public function getTaxRate(): ?float
    {
        return $this->taxRate;
    }

    /**
     * Set taxRate
     * @param float $taxRate
     * @return PurchaseItem
     */
    public function setTaxRate(float $taxRate): self
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    /**
     * Get product
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * Set product
     * @param Product|null $product
     * @return PurchaseItem
     */
    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get getPurchase
     * @return Purchase|null
     */
    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    /**
     * Set getPurchase
     * @param Purchase|null $purchase
     * @return PurchaseItem
     */
    public function setPurchase(?Purchase $purchase): self
    {
        $this->purchase = $purchase;

        return $this;
    }

    /**
     * Return the total price (tax included).
     *
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->product->getPrice() * $this->quantity;
    }


}
