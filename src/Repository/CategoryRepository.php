<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * Find active category.
     *
     * @return mixed
     */
    public function findActiveCategory()
    {
        return $this->getEntityManager()
            ->createQuery('
              SELECT c
              FROM App\Entity\Category c
              LEFT OUTER JOIN App\Entity\Product p WITH p.category = c.id
              LEFT OUTER JOIN App\Entity\Subcategory s WITH p.subcategory = s.id
              WHERE c.enabled = true
              AND p.enabled = true
              ORDER BY c.name, s.name ASC
          ')->getResult();
    }
}