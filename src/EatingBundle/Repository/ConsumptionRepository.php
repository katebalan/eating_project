<?php

namespace EatingBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\AST\Functions\CurrentDateFunction;
use EatingBundle\Entity\Consumption;
use EatingBundle\Entity\User;

class ConsumptionRepository extends EntityRepository
{
    /**
     * @param User $user
     * @return Consumption[]
     */
    public function findByDateAndUserActive(User $user){
        return $this->createQueryBuilder('consumption')
            ->where('consumption.createdAt >= :date')
            ->setParameter(':date', date('Y-m-d'))
            ->andWhere('consumption.user = :user')
            ->setParameter(':user', $user)

            ->getQuery()
            ->execute();
    }

}