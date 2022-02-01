<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="IDX_article_category_id", columns={"article_category_id"})})
 * @ORM\Entity
 */
class Article
{
    /**
     * Number of items per page.
     */
    const NUM_ITEMS = 5;

    /**
     * Id of article
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable="false")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Title of article
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable="false")
     */
    private $title;

    /**
     * Contains of article
     * @var string
     *
     * @ORM\Column(name="contains", type="text", length=0, nullable="false")
     */
    private $contains;

    /**
     * Article creation date
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable="false", options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * Update date of article
     * @var DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable="true")
     */
    private $updatedAt;

    /**
     * Indication whether the article is activated
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable="false")
     */
    private $enabled;



    /**
     * Category of article
     * @var ArticleCategory
     *
     * @ORM\ManyToOne(targetEntity="ArticleCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article_category_id", referencedColumnName="id", nullable="false")
     * })
     */
    private $articleCategory;

    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->enabled = true;
    }

    /**
     * Get Id of article
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get title of article
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set title of article
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Get contains of article
     * @return string
     */
    public function getContains(): string
    {
        return $this->contains;
    }

    /**
     * Set contains of article
     * @param string $contains
     */
    public function setContains(string $contains): void
    {
        $this->contains = $contains;
    }

    /**
     * Get article creation date
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set article creation date
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get update date of article
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set update date of article
     * @param DateTime|null $updatedAt
     */
    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get indication whether the article is activated
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
     * Get category of article
     * @return ArticleCategory
     */
    public function getArticleCategory(): ?ArticleCategory
    {
        return $this->articleCategory;
    }

    /**
     * Set category of article
     * @param ArticleCategory $articleCategory
     */
    public function setArticleCategory(?ArticleCategory $articleCategory): void
    {
        $this->articleCategory = $articleCategory;
    }

}
