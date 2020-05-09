<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\ArticleCategory;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }


    /**
     * Create query for selected articles.
     *
     * @param string $articleCategoryID id of article category
     *
     * @return QueryBuilder
     */
    public function queryLatest(string $articleCategoryID): QueryBuilder
    {
        $qb = $this->createQueryBuilder('article')
            ->addSelect('ArticleCategory')
            ->innerJoin('article.articleCategory', 'articleCategory')
            ->where('article.enabled = true')
            ->andWhere('articleCategory.id = :$articleCategoryID')
            ->orderBy('article.updatedAt', 'DESC')
            ->addOrderBy('article.createdAt', 'DESC')
            ->setParameter('$articleCategoryID', $articleCategoryID);
        ;

        return $qb;
    }

    /**
     * Find latest articles.
     *
     * @param int $page
     *
     * @return Paginator
     */
    public function findLatest(int $page = 1): Paginator
    {
        $qb = $this->queryLatest(ArticleCategory::MAIN_ARTICLE);
        return (new Paginator($qb, Article::NUM_ITEMS))->paginate($page);
    }

    /**
     * Find articles of company.
     *
     * @return mixed
     */
    public function findCompany()
    {
        return $this->queryLatest(ArticleCategory::COMPANY_ARTICLE)->getQuery()->getResult();
    }

    /**
     * Find articles of bandeau.
     *
     * @return mixed
     */
    public function findBandeau()
    {
        return $this->queryLatest(ArticleCategory::BANNER_ARTICLE)->getQuery()->getResult();
    }

    /**
     * Find articles of recipe.
     *
     * @return mixed
     */
    public function findRecipe()
    {
        return $this->queryLatest(ArticleCategory::RECIPE_ARTICLE)->getQuery()->getResult();
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
