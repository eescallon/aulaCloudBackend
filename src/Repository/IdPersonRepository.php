<?php

namespace App\Repository;

use App\Entity\IdPerson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IdPerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method IdPerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method IdPerson[]    findAll()
 * @method IdPerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdPersonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IdPerson::class);
    }

//    /**
//     * @return IdPerson[] Returns an array of IdPerson objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IdPerson
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
