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
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Product.
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="tax_rate_id", columns={"tax_rate_id"}), @ORM\Index(name="subcategory_id", columns={"subcategory_id"}), @ORM\Index(name="IDX_D34A04AD12469DE2", columns={"category_id"})})
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Product
{
    /**
     * Element number per page.
     */
    const NUM_ITEMS = 10;

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
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=false)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_purchase", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isPurchase;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="packaging", type="string", length=100, nullable=true)
     */
    private $packaging;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var string|null
     *
     * @ORM\Column(name="refundable", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $refundable;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \Subcategory
     *
     * @ORM\ManyToOne(targetEntity="Subcategory", inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     * })
     */
    private $subcategory;

    /**
     * @var \TaxRate
     *
     * @ORM\ManyToOne(targetEntity="TaxRate")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tax_rate_id", referencedColumnName="id")
     * })
     */
    private $taxRate;

    /**
     * Constructor of the Product class.
     * (Initialize some fields).
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->enabled = true;
        $this->isPurchase = true;
    }

    /**
     * Get id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get name.
     *
     * @return null|string
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
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return Product
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get description.
     *
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

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
     * @return Product
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
     * Set ImageFile.
     *
     * @param string $image
     *
     * @return Product
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
     * Get isPurchase.
     *
     * @return bool|null
     */
    public function getIsPurchase(): ?bool
    {
        return $this->isPurchase;
    }

    /**
     * Set isPurchase.
     *
     * @param bool $isPurchase
     *
     * @return Product
     */
    public function setIsPurchase(bool $isPurchase): self
    {
        $this->isPurchase = $isPurchase;

        return $this;
    }

    /**
     * Get enabled.
     *
     * @return bool|null
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
     * @return Product
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTimeInterface $createdAt
     *
     * @return Product
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTimeInterface|null $updatedAt
     *
     * @return Product
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get packaging.
     *
     * @return null|string
     */
    public function getPackaging(): ?string
    {
        return $this->packaging;
    }

    /**
     * Set packaging.
     *
     * @param null|string $packaging
     *
     * @return Product
     */
    public function setPackaging(?string $packaging): self
    {
        $this->packaging = $packaging;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price.
     *
     * @param $price
     *
     * @return Product
     */
    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get refundable.
     *
     * @return null|string
     */
    public function getRefundable()
    {
        return $this->refundable;
    }

    /**
     * Set refundable.
     *
     * @param $refundable
     *
     * @return Product
     */
    public function setRefundable($refundable): self
    {
        $this->refundable = $refundable;

        return $this;
    }

    /**
     * Get category.
     *
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Set category.
     *
     * @param Category|null $category
     *
     * @return Product
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get subcategory.
     *
     * @return Subcategory|null
     */
    public function getSubcategory(): ?Subcategory
    {
        return $this->subcategory;
    }

    /**
     * Set subcategory.
     *
     * @param Subcategory|null $subcategory
     *
     * @return Product
     */
    public function setSubcategory(?Subcategory $subcategory): self
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    /**
     * Get taxRate.
     *
     * @return TaxRate|null
     */
    public function getTaxRate(): ?TaxRate
    {
        return $this->taxRate;
    }

    /**
     * Set taxRate.
     *
     * @param TaxRate|null $taxRate
     *
     * @return Product
     */
    public function setTaxRate(?TaxRate $taxRate): self
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    /**
     * Get String information of product.
     *
     * @return string Name of product
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Replace filename for validation.
     *
     * @param string $originFilename origin of filename
     *
     * @return string valid filename
     */
    private function getValidFilename(string $originFilename): string
    {
        //remplacement lettres accentuées par équivalent
        $modifiedFilename = strtr($originFilename ,
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');

        //n'autorise que les lettres et les chiffres et les caractères '_' et '-'; remplace tous les autres caractères par '-'
        return preg_replace('/([^.a-z0-9_-]+)/i', '-', $modifiedFilename);
    }
}
