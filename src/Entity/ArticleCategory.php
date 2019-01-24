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

/**
 * ArticleCategory.
 *
 * @ORM\Table(name="article_category")
 * @ORM\Entity
 */
class ArticleCategory
{
    /**
     * Element number per page.
     */
    const ARTICLE_PRINCIPAL = 1;

    /**
     * Element number per page.
     */
    const ARTICLE_ENTERPRISE = 2;

    /**
     * Element number per page.
     */
    const ARTICLE_BANDEAU = 3;

    /**
     * Id of recipe article.
     */
    const ARTICLE_RECIPE = 4;

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
     * Get id.
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return ArticleCategory
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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
     * @return ArticleCategory
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get String information of article category.
     *
     * @return string Name of article category
     */
    public function __toString()
    {
        return $this->getName();
    }
}
