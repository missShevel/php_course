<?php

namespace App\Entity;

use App\Repository\IssueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IssueRepository::class)]
class Issue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Book::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Book $book;

    #[ORM\ManyToOne(targetEntity: Reader::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Reader $reader;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $issuedAt;
    public function getId(): ?int
    {
        return $this->id;
    }
}
