<?php

namespace MyBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findEntitiesByString($str)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT p 
        FROM MyBundle:Product p
        WHERE p.productname LIKE :str'

            )->setParameter('str', '%'.$str.'%')->getResult();
    }
}
