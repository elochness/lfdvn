<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Subcategory
 *
 * @ORM\Table(name="subcategory", indexes={@ORM\Index(name="IDX_category_id", columns={"category_id"})})
 * @ORM\Entity
 */
class Subcategory
{
    /**
     * Subcategory ID
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Name of subcategory
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * Indication whether the category is activated
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled = true;

    /**
     * Category of the subcategory
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="subcategories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var Product[]
     * @ORM\OneToMany(targetEntity="Product", mappedBy="subcategory")
     */
    private $products;

    /**
     * Subcategory constructor.
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * Get subcategory ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get name of the subcategory
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name of the subcategory
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
     * Set indication whether the category is activated
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * Get category of the subcategory
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * Set category of the subcategory
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * Get products of the subcategory
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set products of the subcategory
     * @param Product[] $products
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }
    /**
     * Add product.
     * @param Product $product
     * @return Category
     */
    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    /**
     * Remove product.
     * @param Product $product
     */
    public function removeProduct(Product $product): void
    {
        $this->products->removeElement($product);
    }

    /**
     * Get information of subcategory.
     * @return string Name of subcategory
     */
    public function __toString(): string
    {
        return $this->getName();
    }

}
