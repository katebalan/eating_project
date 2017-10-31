<?php

namespace EatingBundle\Repository;


use Doctrine\ORM\EntityRepository;
use EatingBundle\Entity\Products;

class ProductsRepository extends EntityRepository
{
    /**
     * @return Products[]
     */
    public function findAllOrderedByDescActive(){
        return $this->createQueryBuilder('products')
            ->orderBy('products.createdAt', 'DESC')

            ->getQuery()
            ->execute();
    }
}
