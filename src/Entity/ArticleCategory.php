<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleCategory
 *
 * @ORM\Table(name="article_category")
 * @ORM\Entity
 */
class ArticleCategory
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


}
