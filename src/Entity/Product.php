<?php

namespace App\Entity;

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
     * @var bool
     *
     * @ORM\Column(name="is_purchase", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isPurchase = true;

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
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \Subcategory
     *
     * @ORM\ManyToOne(targetEntity="Subcategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     * })
     */
    private $subcategory;

    /**
     * @var \VatRate
     *
     * @ORM\ManyToOne(targetEntity="VatRate")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vat_rate_id", referencedColumnName="id")
     * })
     */
    private $vatRate;


}
