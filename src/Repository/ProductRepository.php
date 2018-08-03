<?php
/**
 * Created by PhpStorm.
 * User: INUFRAP
 * Date: 18/07/2018
 * Time: 13:26
 */

namespace App\Repository;


use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProductRepository extends ServiceEntityRepository
{

    /**
     * ProductRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @param array $params
     * @return Query
     */
    public function queryLatest(array $params)
    {
        $queryString = '
              SELECT p
              FROM App\Entity\Product p
              INNER JOIN App\Entity\Category c WITH p.category = c.id
              LEFT OUTER JOIN App\Entity\Subcategory s WITH p.subcategory = s.id
              WHERE p.enabled = true
            ';

        $queryOrder = '
            ORDER BY p.name ASC, c.name ASC
            ';

        if(isset($params))
        {
            $queryFilter = $this->getFilters($params);
            $query = $this->getEntityManager()->createQuery($queryString .  $queryFilter . $queryOrder);
            $this->addParameters($params, $query);
            return $query;
        } else {
            return $this->getEntityManager()->createQuery($queryString . $queryOrder);
        }
    }

    /**
     * @param $page
     * @param array $params
     * @return Pagerfanta
     */
    public function findLatest($page,array $params): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryLatest($params), false));
        $paginator->setMaxPerPage(Product::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    /**
     * Add filter for request
     *
     * @param array $params
     * @param Query $query
     */
    private function addParameters(array $params, Query $query) {
        if(isset($params['category'])) {
            $query->setParameter('cid', $params['category']);
        }
        if (isset($params['subcategory'])) {
            $query->setParameter('sid', $params['subcategory']);
        }
    }

    private function getFilters($params) {
        $queryFilter = '';

        if(isset($params['category'])) {
            $queryFilter .= ' AND c.id = :cid ';
        }
        if (isset($params['subcategory'])) {
            $queryFilter .= ' AND s.id = :sid ';
        }

        return $queryFilter;
    }
}