<?php

namespace App\Repository;

use App\Entity\Burger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Burger>
 */
class BurgerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Burger::class);
    }

    //    /**
    //     * @return Burger[] Returns an array of Burger objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Burger
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findBurgersWithIngredients(string $ingredients): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT burger
             FROM App\Entity\Burger burger
             LEFT JOIN burger.oignons oignon
             LEFT JOIN burger.sauce sauce
             WHERE oignon.name = :ingredient OR sauce.name = :ingredient'
        )->setParameter('ingredient', $ingredients);

        return $query->getResult();
    }
    public function findTopXBurgers(int $limit): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT b
         FROM App\Entity\Burger b
         ORDER BY b.price DESC'
        )->setMaxResults($limit);

        return $query->getResult();
    }

    public function findBurgersWithoutIngredient(string $ingredientName): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT b
         FROM App\Entity\Burger b
         LEFT JOIN b.oignons o
         LEFT JOIN b.sauce s
         LEFT JOIN b.pain p
         WHERE (o.name != :ingredient OR o.name IS NULL)
           AND (s.name != :ingredient OR s.name IS NULL)
           AND (p.name != :ingredient OR p.name IS NULL)'
        )->setParameter('ingredient', $ingredientName);

        return $query->getResult();
    }
}
