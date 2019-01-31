<?php

namespace App\Repository;

use App\Entity\Vehicule;
use App\Entity\VehiculeSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

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
        return $query->getQuery()->getResult();
    }
}
