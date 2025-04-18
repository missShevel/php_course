<?php

namespace App\Repository;

use App\Entity\Issue;
use App\Repository\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Issue>
 */
class IssueRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Issue::class);
    }

//    /**
//     * @return Issue[] Returns an array of Issue objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Issue
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findFilteredPaginated(array $filters, int $page, int $itemsPerPage): array
{
    $qb = $this->createQueryBuilder('i')->orderBy('i.id', 'ASC');

    if (!empty($filters['book_id'])) {
        $qb->andWhere('i.book = :book_id')
        ->setParameter('book_id', $filters['book_id']);
    }
    
    if (!empty($filters['reader_id'])) {
        $qb->andWhere('i.reader = :reader_id')
        ->setParameter('reader_id', $filters['reader_id']);
    }


    if (!empty($filters['issued_at'])) {
        $issuedAt = \DateTime::createFromFormat('Y-m-d', $filters['issued_at']);

        if ($issuedAt) {
            // Match full date
            $qb->andWhere('i.issuedAt = :issued_at')
                ->setParameter('issued_at', $issuedAt->format('Y-m-d'));
        }
    }

    return $this->paginate($qb, $page, $itemsPerPage);
}

}
