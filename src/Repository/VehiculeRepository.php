<?php

namespace App\Repository;

use App\Entity\Vehicule;
use App\Entity\Location;
use App\Entity\VehiculeSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Vehicule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicule[]    findAll()
 * @method Vehicule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class VehiculeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vehicule::class);
        // parent::__construct($registry, Location::class);
    }

    public function findSearchVehicule(vehiculeSearch $search)
    {
        $query = $this->createQueryBuilder('v');
        
        // if($search->getVille() || $search->getTypeVehicule()) {
        //     $query = $query
        //             ->where('v.ville = :ville')
        //             ->andWhere('v.type = :typeVehicule')
        //             ->setParameter('ville', $search->getVille())
        //             ->setParameter('typeVehicule', $search->getTypeVehicule());
        // }

        // if($search->getStart() && $search->getEnd()) {
        //     $query
        //             ->innerJoin(Location::class, 'l', Join::WITH, 'v.id = l.vehicule')
        //             ->andWhere(':start NOT BETWEEN l.start AND l.end')
        //             ->andWhere(':end NOT BETWEEN l.start AND l.end')
        //             ->setParameter('start', $search->getStart())
        //             ->setParameter('end', $search->getEnd());
        // }


        if($search->getStart()) $start = $search->getStart();
        else $start = new \Datetime();

        // $query
        //     ->where('v.ville = :ville')
        //     ->andWhere('v.type = :typeVehicule')
        //     ->innerJoin('v.locations', 'l')
        //     ->andWhere('l.start NOT BETWEEN :from AND :to')
        //     ->setParameter('ville', $search->getVille())
        //     ->setParameter('typeVehicule', $search->getTypeVehicule())
        //     ->setParameter('from', new \Datetime($start->format('Y-m-d') . ' 00:00:00'))
        //     ->setParameter('to', new \Datetime($start->format('Y-m-d') . ' 23:59:59'));

        $query
            ->select('v.id')
            ->where('v.ville = :ville')
            ->andWhere('v.type = :typeVehicule')
            ->innerJoin('v.locations', 'l')
            ->andWhere('l.start BETWEEN :from AND :to')
            ->setParameter('ville', $search->getVille())
            ->setParameter('typeVehicule', $search->getTypeVehicule())
            ->setParameter('from', new \Datetime($start->format('Y-m-d') . ' 00:00:00'))
            ->setParameter('to', new \Datetime($start->format('Y-m-d') . ' 23:59:59'));

        $ids = $query->getQuery()->getResult();

        $query2 = $this->createQueryBuilder('v')
            ->where('v.ville = :ville')
            ->andWhere('v.type = :typeVehicule')
            ->setParameter('ville', $search->getVille())
            ->setParameter('typeVehicule', $search->getTypeVehicule());

        if (count($ids) > 0) 
        {
            $query2
                ->andWhere('v.id NOT IN(:ids)')
                ->setParameter('ids', $ids);
        }

        return $query2->getQuery()->getResult();
    }
}
