<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;

abstract class BaseRepository extends ServiceEntityRepository
{
    public function paginate(QueryBuilder $qb, int $page, int $itemsPerPage): array
    {
        $offset = ($page - 1) * $itemsPerPage;

        $paginator = new Paginator(
            $qb->setFirstResult($offset)->setMaxResults($itemsPerPage),
            true
        );

        return [
            'data' => iterator_to_array($paginator),
            'total' => count($paginator),
        ];
    }
}
