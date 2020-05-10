<?php

namespace App\Repository;

use App\Entity\Product;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }


    /**
     * Create query for selected products.
     *
     * @param array $params
     *
     * @return QueryBuilder
     */
    public function queryLatest(array $params): QueryBuilder
    {
        $qb = $this->createQueryBuilder('product')
            ->addSelect('ArticleCategory')
            ->innerJoin('product.category', 'category')
            ->leftJoin('product.subcategory', 'subcategory')
            ->where('product.enabled = true')
            ->andWhere('articleCategory.id = :$articleCategoryID')
            ->orderBy('product.name', 'ASC')
            ->addOrderBy('category.name', 'ASC')
        ;

        if (isset($params)) {
            if (isset($params['category'])) {
                $qb->andWhere(' AND category.id = :cid ');
                $qb->setParameter('cid', $params['category']);
            }
            if (isset($params['subcategory'])) {
                $qb->andWhere(' AND subcategory.id = :sid ');
                $qb->setParameter('sid', $params['subcategory']);
            }
        }

        return $qb;
    }

    /**
     * Find latest products.
     *
     * @param array $params
     * @param int $page
     *
     * @return Paginator
     */
    public function findLatest(array $params, int $page = 1): Paginator
    {
        $qb = $this->queryLatest($params);
        return (new Paginator($qb, Product::NUM_ITEMS))->paginate($page);
    }
}
