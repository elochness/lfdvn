<?php

namespace App\Repository;

use App\Entity\ProductOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductOrder[]    findAll()
 * @method ProductOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductOrder::class);
    }

    /**
     * @param int $uid
     *
     * @return mixed
     */
    public function findByBuyer(int $uid)
    {
        $query = $this->getEntityManager()
            ->createQuery('
              SELECT p
              FROM App\Entity\ProductOrder p
              INNER JOIN App\Entity\User u
              WITH p.user = u.id
              WHERE p.user = :uid
              ORDER BY p.deliveryDate, p.createdAt DESC
          ')
        ;
        $query->setParameter('uid', $uid);

        return $query->getResult();
    }
}
