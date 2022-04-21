<?php

namespace App\Repository;

use App\Entity\Transporteurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transporteurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transporteurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transporteurs[]    findAll()
 * @method Transporteurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransporteursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transporteurs::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Transporteurs $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Transporteurs $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    //Retourne le nombre total de transporteur dans la bdd
    public function totalTransporteur(): int {
        $query = $this->createQueryBuilder('transporteurs')
                      ->select('count(transporteurs)');
        return $query->getQuery()->getSingleScalarResult();
    }



    // /**
    //  * @return Transporteurs[] Returns an array of Transporteurs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Transporteurs
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
