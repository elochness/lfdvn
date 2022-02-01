<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductOrderItem
 *
 * @ORM\Table(name="product_order_item", indexes={@ORM\Index(name="IDX_product_order_id", columns={"product_order_id"}), @ORM\Index(name="IDX_product_id", columns={"product_id"})})
 * @ORM\Entity
 */
class ProductOrderItem
{
    /**
     * Item of the product order ID
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Quantity of item of the product order
     * @var int
     *
     * @ORM\Column(name="quantity", type="smallint", nullable=false)
     */
    private $quantity;

    /**
     * Price of item of the product order
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * VAT rate of item of the product order
     * @var float
     *
     * @ORM\Column(name="vat_rate", type="float", precision=10, scale=0, nullable=false)
     */
    private $vatRate;

    /**
     * Product of item of the product order
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * The product order
     * @var ProductOrder
     *
     * @ORM\ManyToOne(targetEntity="ProductOrder", inversedBy="items")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_order_id", referencedColumnName="id")
     * })
     */
    private $productOrder;

    /**
     * Get Item of the product order ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get quantity of item of the product order ID
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Set quantity of item of the product order ID
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * Get price of item of the product order ID
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Set price of item of the product order ID
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * Get VAT rate of item of the product order ID
     * @return float
     */
    public function getVatRate(): float
    {
        return $this->vatRate;
    }

    /**
     * Set VAT rate of item of the product order ID
     * @param float $vatRate
     */
    public function setVatRate(float $vatRate): void
    {
        $this->vatRate = $vatRate;
    }

    /**
     * Get product of item of the product order ID
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * Set product of item of the product order ID
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * Get product order
     * @return ProductOrder
     */
    public function getProductOrder(): ProductOrder
    {
        return $this->productOrder;
    }

    /**
     * Set product order
     * @param ProductOrder $productOrder
     */
    public function setProductOrder(ProductOrder $productOrder): void
    {
        $this->productOrder = $productOrder;
    }

    /**
     * Get String information of product order item.
     * @return string
     */
    public function __toString()
    {
        if (isset($this->product)) {
            return $this->product->getName() . ' x' . $this->getQuantity();
        }
        // TODO change string in constant
        return 'Non défini';
    }

    /**
     * Return the full price (tax included).
     *
     * @return float
     */
    public function getFullPrice()
    {
        return $this->product->getPrice() * $this->quantity;
    }
}
