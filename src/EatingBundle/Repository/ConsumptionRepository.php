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
     * @param $date
     * @return Consumption[]
     */
    public function findByDateAndUserActive(User $user, $date){
        return $this->createQueryBuilder('consumption')
            ->where('consumption.createdAt >= :date_first')
            ->andwhere('consumption.createdAt <= :date_second')
            ->andWhere('consumption.user = :user')
            ->setParameter(':date_first', $date.' 00:00:00')
            ->setParameter(':date_second', $date.' 23:59:59')
            ->setParameter(':user', $user)

            ->getQuery()
            ->execute();
    }

}