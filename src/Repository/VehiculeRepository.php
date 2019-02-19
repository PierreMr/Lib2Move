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

        
        if($search->getVille() || $search->getTypeVehicule()) {
            $query = $query
                    ->where('v.ville = :ville')
                    ->andWhere('v.type = :typeVehicule')
                    ->setParameter('ville', $search->getVille())
                    ->setParameter('typeVehicule', $search->getTypeVehicule());
        }

        if($search->getStart() && $search->getEnd()) {
            $query
                    ->innerJoin(Location::class, 'l', Join::WITH, 'v.id = l.vehicule')
                    ->andWhere(':start NOT BETWEEN l.start AND l.end')
                    ->andWhere(':end NOT BETWEEN l.start AND l.end')
                    ->setParameter('start', $search->getStart())
                    ->setParameter('end', $search->getEnd());
        }

        return $query->getQuery()->getResult();
    }
}
