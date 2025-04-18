<?php

namespace App\Repository;

use App\Entity\Reader;
use App\Repository\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reader>
 */
class ReaderRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reader::class);
    }

//    /**
//     * @return Reader[] Returns an array of Reader objects
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

//    public function findOneBySomeField($value): ?Reader
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findFilteredPaginated(array $filters, int $page, int $itemsPerPage): array
{
    $qb = $this->createQueryBuilder('r')->orderBy('r.id', 'ASC');

    if (!empty($filters['name'])) {
        $qb->andWhere('r.name LIKE :name')
           ->setParameter('name', '%' . $filters['name'] . '%');
    }


    if (!empty($filters['email'])) {
        $qb->andWhere('r.email LIKE :email')
           ->setParameter('email', '%' . $filters['email'] . '%');
    }

    return $this->paginate($qb, $page, $itemsPerPage);
}
}
