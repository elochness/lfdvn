<?php
/**
 * Created by PhpStorm.
 * User: INUFRAP
 * Date: 18/07/2018
 * Time: 13:24
 */

namespace App\Repository;


use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CategoryRepository extends ServiceEntityRepository
{

    /**
     * CategoryRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * Find active category
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
              ORDER BY c.name ASC
          ')->getResult();
    }
}