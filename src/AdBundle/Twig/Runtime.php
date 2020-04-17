<?php

namespace AdBundle\Twig;

use Twig\Extension\RuntimeExtensionInterface;
use AdBundle\Entity\Ad;
use Doctrine\ORM\EntityManagerInterface;

class Runtime implements RuntimeExtensionInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function retrieveAds()
    {
        $time ="1";

        $query = $this->em->createQuery(
            'SELECT p
            FROM AdBundle\Entity\Ad p
           WHERE p.id = :date'
        )
            ->setParameter('date', $time);
        $tab= $query->getResult();
        return $tab;
    }




}