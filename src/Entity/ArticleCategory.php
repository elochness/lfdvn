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
     * Id of main article.
     */
    const MAIN_ARTICLE = 1;

    /**
     * Id of company article.
     */
    const COMPANY_ARTICLE = 2;

    /**
     * Id of banner article.
     */
    const BANNER_ARTICLE = 3;

    /**
     * Id of recipe article.
     */
    const RECIPE_ARTICLE = 4;

    /**
     * Article category ID
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * Name of article category
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * Get article category ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set article category ID
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Get name of article category
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name of article category
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
