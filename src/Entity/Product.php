<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="IDX_subcategory_id", columns={"subcategory_id"}), @ORM\Index(name="IDX_category_id", columns={"category_id"}), @ORM\Index(name="IDX_vat_rate_id", columns={"vat_rate_id"})})
 * @ORM\Entity
 */
class Product
{
    /**
     * Number of items per page.
     */
    const NUM_ITEMS = 10;

    /**
     * Product ID
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Name of the product
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * Quantity of the product
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * Description of the product
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=false)
     */
    private $description;

    /**
     * Image of the product
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * Indication whether the product can be ordered
     * @var bool
     *
     * @ORM\Column(name="is_can_be_ordered", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isCanBeOrdered = true;

    /**
     * Indication whether the product is activated
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled = true;

    /**
     * Product creation date
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * Update date of product
     * @var DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * Packaging of the product
     * @var string|null
     *
     * @ORM\Column(name="packaging", type="string", length=100, nullable=true)
     */
    private $packaging;

    /**
     * Price of the product
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * Refundable of the product
     * @var string|null
     *
     * @ORM\Column(name="refundable", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $refundable;

    /**
     * Category of the product
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * Subcategory of the product
     * @var Subcategory
     *
     * @ORM\ManyToOne(targetEntity="Subcategory", inversedBy="products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     * })
     */
    private $subcategory;

    /**
     * VAT Rate of the product
     * @var VatRate
     *
     * @ORM\ManyToOne(targetEntity="VatRate")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vat_rate_id", referencedColumnName="id")
     * })
     */
    private $vatRate;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt =  new DateTime();
    }


    /**
     * Get product ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get name of the product
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name of the product
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get quantity of the product
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Set quantity of the product
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * Get description of the product
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set description of the product
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get image of the product
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Set image of the product
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * Get indication whether the product can be ordered
     * @return bool
     */
    public function isCanBeOrdered(): bool
    {
        return $this->isCanBeOrdered;
    }

    /**
     * Set indication whether the product can be ordered
     * @param bool $isCanBeOrdered
     */
    public function setIsCanBeOrdered(bool $isCanBeOrdered): void
    {
        $this->isCanBeOrdered = $isCanBeOrdered;
    }

    /**
     * Get indication whether the product is activated
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Set indication whether the product is activated
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * Get product creation date
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set product creation date
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get update date of product
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set update date of product
     * @param DateTime|null $updatedAt
     */
    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get packaging of the product
     * @return string|null
     */
    public function getPackaging(): ?string
    {
        return $this->packaging;
    }

    /**
     * Set packaging of the product
     * @param string|null $packaging
     */
    public function setPackaging(?string $packaging): void
    {
        $this->packaging = $packaging;
    }

    /**
     * Get price of the product
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * Set price of the product
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * Get refundable of the product
     * @return string|null
     */
    public function getRefundable(): ?string
    {
        return $this->refundable;
    }

    /**
     * Set refundable of the product
     * @param string|null $refundable
     */
    public function setRefundable(?string $refundable): void
    {
        $this->refundable = $refundable;
    }

    /**
     * Get category of the product
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Set category of the product
     * @param Category|null $category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * Get subcategory of the product
     * @return Subcategory|null
     */
    public function getSubcategory(): ?Subcategory
    {
        return $this->subcategory;
    }

    /**
     * Set subcategory of the product
     * @param Subcategory|null $subcategory
     */
    public function setSubcategory(?Subcategory $subcategory): void
    {
        $this->subcategory = $subcategory;
    }

    /**
     * Get VAT rate of the product
     * @return VatRate
     */
    public function getVatRate(): ?VatRate
    {
        return $this->vatRate;
    }

    /**
     * Set VAT rate of the product
     * @param VatRate $vatRate
     */
    public function setVatRate(VatRate $vatRate): void
    {
        $this->vatRate = $vatRate;
    }

    /**
     * Get String information of the product.
     * @return string Name of the product
     */
    public function __toString(): string
    {
        return $this->name;
    }


}
