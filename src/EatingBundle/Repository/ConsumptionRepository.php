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
    public function findByDateAndUserActive(User $user, \Datetime $date)
    {
        $from = new \DateTime($date->format("Y-m-d")." 00:00:00");
        $to   = new \DateTime($date->format("Y-m-d")." 23:59:59");

        $qb = $this->createQueryBuilder("e");
        $qb
            ->andWhere('e.createdAt BETWEEN :from AND :to')
            ->andWhere('e.user = :user')
            ->setParameter('from', $from )
            ->setParameter('to', $to)
            ->setParameter(':user', $user)
        ;
        $result = $qb->getQuery()->getResult();

        return $result;
    }

}