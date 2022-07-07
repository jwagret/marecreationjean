<?php

namespace App\Repository;

use App\Entity\Clients;
use App\Entity\Commandes;
use App\Entity\Produits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commandes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commandes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commandes[]    findAll()
 * @method Commandes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commandes::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Commandes $entity, bool $flush = true): void
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
    public function remove(Commandes $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    //Retourne le nombre total de transporteur dans la bdd
    public function totalCommandes(): int {
        $query = $this->createQueryBuilder('commandes')
                      ->select('count(commandes)');
        return $query->getQuery()->getSingleScalarResult();
    }

    //Retourne les commandes d'un client
    public function afficherCommandes(Clients $clients) {
        $query = $this->createQueryBuilder('commandes')
                      ->join('commandes.client', 'cc')
                      ->where('cc.refClient = :key')
                      ->setParameter('key', $clients->getRefClient());
        return $query->getQuery()->getResult();
    }











    // /**
    //  * @return Commandes[] Returns an array of Commandes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Commandes
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
