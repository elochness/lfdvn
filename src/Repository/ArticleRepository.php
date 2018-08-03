<?php
/**
 * Created by PhpStorm.
 * User: INUFRAP
 * Date: 18/07/2018
 * Time: 12:49
 */

namespace App\Repository;


use App\Entity\Article;
use App\Entity\ArticleCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class ArticleRepository
 * @package App\Repository
 */
class ArticleRepository extends ServiceEntityRepository
{

    /**
     * ArticleRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }


    /**
     * Create query for selected articles
     * @param string $caid id of article category
     * @return Query
     */
    public function queryLatest(string $caid = ArticleCategory::ARTICLE_PRINCIPAL): Query
    {
        $query = $this->getEntityManager()
            ->createQuery('
              SELECT a
              FROM App\Entity\Article a
              INNER JOIN App\Entity\ArticleCategory ac
              WITH a.articleCategory = ac.id
              WHERE a.enabled = true
              AND ac.id = :caid
              ORDER BY a.updatedAt DESC, a.createdAt DESC
          ')
        ;
        $query->setParameter('caid', $caid);
        return $query;
    }

    /**
     * Create a paginator for articles
     * @param Query $query
     * @param int $page
     * @return Pagerfanta
     */
    private function createPaginator(Query $query, int $page): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage(Article::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    /**
     * Find latest articles
     * @param int $page
     * @return Pagerfanta
     */
    public function findLatest(int $page = 1)
    {
        return $this->createPaginator( $this->queryLatest(), $page);
    }

    /**
     * Find articles of enterprise
     * @return mixed
     */
    public function findEnterprise()
    {
        return $this->queryLatest(ArticleCategory::ARTICLE_ENTERPRISE)->getResult();
    }

    /**
     * Find articles of bandeau
     * @return mixed
     */
    public function findBandeau()
    {
        return $this->queryLatest(ArticleCategory::ARTICLE_BANDEAU)->getResult();
    }

    /**
     * Find articles of recipe
     * @return mixed
     */
    public function findRecipe()
    {
        return $this->queryLatest(ArticleCategory::ARTICLE_RECIPE)->getResult();
    }

}