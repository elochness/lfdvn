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
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var \ProductOrder
     *
     * @ORM\ManyToOne(targetEntity="ProductOrder")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_order_id", referencedColumnName="id")
     * })
     */
    private $productOrder;


}
