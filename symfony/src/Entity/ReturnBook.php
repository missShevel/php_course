<?php

namespace App\Entity;

use App\Repository\ReturnBookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReturnBookRepository::class)]
class ReturnBook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Issue::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Issue $issue;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $returnedAt;

    public function getId(): ?int
    {
        return $this->id;
    }
}
