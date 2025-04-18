<?php

namespace App\Repository;

use App\Entity\Author;
use App\Repository\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

//    /**
//     * @return Author[] Returns an array of Author objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findFilteredPaginated(array $filters, int $page, int $itemsPerPage): array
{
    $qb = $this->createQueryBuilder('a')->orderBy('a.id', 'ASC');

    if (!empty($filters['name'])) {
        $qb->andWhere('a.name LIKE :name')
           ->setParameter('name', '%' . $filters['name'] . '%');
    }


    if (!empty($filters['birth_date'])) {
        $publishedAt = \DateTime::createFromFormat('Y-m-d', $filters['birth_date']);

        if ($publishedAt) {
            // Match full date
            $qb->andWhere('a.birthDate = :birth_date')
                ->setParameter('birth_date', $publishedAt->format('Y-m-d'));
        }
    }

    return $this->paginate($qb, $page, $itemsPerPage);
}

}
