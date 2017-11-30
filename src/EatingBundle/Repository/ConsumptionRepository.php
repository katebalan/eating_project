<?php

namespace EatingBundle\Repository;


use Doctrine\ORM\EntityRepository;
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
            ->where('createdAt >= 2017-11-30 00:14:56')
            ->andWhere('user' == $user)

            ->getQuery()
            ->execute();
    }

}