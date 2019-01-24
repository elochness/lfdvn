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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Category.
 *
 * @ORM\Table(name="category")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Category
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=30, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="category_images", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var Subcategory[]
     * @ORM\OneToMany(targetEntity="Subcategory", mappedBy="category")
     */
    private $subcategories;

    /**
     * @var ?Product[]
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    private $products;

    /**
     * Constructor of the Product class.
     * (Initialize some fields).
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->subcategories = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get image.
     *
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Set image.
     *
     * @param string $image
     *
     * @return Category
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get imageFile.
     *
     * @return string
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set imageFile.
     *
     * @param string $image
     *
     * @return Category
     */
    public function setImageFile($image = null): self
    {
        // $this->imageFile = $this->getValidFilename($image);
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * Get all subcategories.
     *
     * @return Subcategory[]
     */
    public function getSubcategories()
    {
        return $this->subcategories;
    }

    /**
     * Get enabled.
     *
     * @return bool
     */
    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    /**
     * Set enabled.
     *
     * @param bool $enabled
     *
     * @return Category
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTimeInterface $updatedAt
     *
     * @return Category
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
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
     * Set all subcategories.
     *
     * @param $subcategories
     *
     * @return mixed
     */
    public function setSubcategories($subcategories)
    {
        return $this->subcategories = $subcategories;
    }

    /**
     * Add subcategory.
     *
     * @param Subcategory $subcategory
     *
     * @return Category
     */
    public function addSubcategories(Subcategory $subcategory)
    {
        $this->subcategories[] = $subcategory;

        return $this;
    }

    /**
     * Remove subcategory.
     *
     * @param Subcategory $subcategory
     */
    public function removeSubcategories(Subcategory $subcategory)
    {
        $this->subcategories->removeElement($subcategory);
    }

    /**
     * Get all products.
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set all products.
     *
     * @param $products
     *
     * @return Category
     */
    public function setProducts($products): self
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Add product.
     *
     * @param Product $product
     *
     * @return Category
     */
    public function addProduct(Product $product): self
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product.
     *
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        $this->products->removeElement($product);
    }
}
