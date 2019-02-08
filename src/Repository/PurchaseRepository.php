<?php

/*
 * This file is part of the lfdvn package.
 *
 * (c) Pierre François
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Purchase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PurchaseRepository extends ServiceEntityRepository
{
    /**
     * PurchaseRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Purchase::class);
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
              FROM App\Entity\Purchase p
              INNER JOIN App\Entity\User u
              WITH p.buyer = u.id
              WHERE p.buyer = :uid
              ORDER BY p.deliveryDate, p.createdAt DESC
          ')
        ;
        $query->setParameter('uid', $uid);

        return $query->getResult();
    }
}
