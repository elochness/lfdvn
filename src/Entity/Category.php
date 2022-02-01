<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity
 */
class Category
{
    /**
     * Category ID
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Name of the category
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * Image of the category
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=30, nullable=true)
     */
    private $image;

    /**
     * Indication whether the category is activated
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * Update date of category
     * @var DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * Subcategories of the category
     * @var Subcategory[]
     * @ORM\OneToMany(targetEntity="Subcategory", mappedBy="category")
     */
    private $subcategories;

    /**
     * Products of the category
     * @var ?Product[]
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    private $products;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->subcategories = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    /**
     * Get String information of category.
     *
     * @return string Name of category
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get category ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get name of the category
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name of the category
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Set image of the category
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Get image of the category
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * Get indication whether the category is activated
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Set indication whether the article is activated
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * Set update date of the category
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set update date of the category
     * @param DateTime|null $updatedAt
     */
    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get subcategories of the category
     * @return Subcategory[]
     */
    public function getSubcategories()
    {
        return $this->subcategories;
    }

    /**
     * Set subcategories of the category
     * @param Subcategory[] $subcategories
     */
    public function setSubcategories(array $subcategories): void
    {
        $this->subcategories = $subcategories;
    }

    /**
     * Add subcategory.
     * @param Subcategory $subcategory
     */
    public function addSubcategories(Subcategory $subcategory):void
    {
        $this->subcategories[] = $subcategory;
    }

    /**
     * Remove subcategory.
     * @param Subcategory $subcategory
     */
    public function removeSubcategories(Subcategory $subcategory): void
    {
        $this->subcategories->removeElement($subcategory);
    }

    /**
     * Get products of the category
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set products of the category
     * @param mixed $products
     */
    public function setProducts($products): void
    {
        $this->products = $products;
    }

    /**
     * Add product of the category
     * @param Product $product
     */
    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    /**
     * Remove product of the category
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        $this->products->removeElement($product);
    }


}
