<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

//    /**
//     * @return Book[] Returns an array of Book objects
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

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findByFilters(array $filters): array
{
    $qb = $this->createQueryBuilder('b');

    if (!empty($filters['title'])) {
        $qb->andWhere('b.title LIKE :title')
           ->setParameter('title', '%' . $filters['title'] . '%');
    }

    if (!empty($filters['genre'])) {
        $qb->andWhere('b.genre = :genre')
           ->setParameter('genre', $filters['genre']);
    }

    if (!empty($filters['published_at'])) {
        $publishedAt = \DateTime::createFromFormat('Y-m-d', $filters['published_at']);

        if ($publishedAt) {
            // Match full date
            $qb->andWhere('b.published_at = :published_at')
                ->setParameter('published_at', $publishedAt->format('Y-m-d'));
        }
    }

    if (!empty($filters['author_id'])) {
        $qb->andWhere('b.author = :author_id')
        ->setParameter('author_id', $filters['author_id']);
    }

    return $qb->getQuery()->getResult();
}

}
