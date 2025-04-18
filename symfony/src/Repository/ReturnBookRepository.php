<?php

namespace App\Repository;

use App\Entity\ReturnBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReturnBook>
 */
class ReturnBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReturnBook::class);
    }

//    /**
//     * @return ReturnBook[] Returns an array of ReturnBook objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReturnBook
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findByFilters(array $filters): array
{
    $qb = $this->createQueryBuilder('r');

    if (!empty($filters['issue_id'])) {
        $qb->andWhere('r.issue = :issue_id')
        ->setParameter('issue_id', $filters['issue_id']);
    }

    if (!empty($filters['returned_at'])) {
        $returnedAt = \DateTime::createFromFormat('Y-m-d', $filters['returned_at']);

        if ($returnedAt) {
            // Match full date
            $qb->andWhere('r.returnedAt = :returned_at')
                ->setParameter('returned_at', $returnedAt->format('Y-m-d'));
        }
    }
    return $qb->getQuery()->getResult();
}
}
