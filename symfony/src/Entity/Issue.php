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
    #[Groups(['issue:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Book::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['issue:read'])]
    private Book $book;

    #[ORM\ManyToOne(targetEntity: Reader::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['issue:read'])]
    private Reader $reader;

    #[ORM\Column(type: "datetime")]
    #[Groups(['issue:read'])]
    private \DateTimeInterface $issuedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;
        return $this;
    }

    public function getReader(): ?Reader
    {
        return $this->reader;
    }

    public function setReader(?Reader $reader): self
    {
        $this->reader = $reader;
        return $this;
    }

    public function getIssuedAt(): ?\DateTimeInterface
    {
        return $this->issuedAt;
    }

    public function setIssuedAt(\DateTimeInterface $issuedAt): self
    {
        $this->issuedAt = $issuedAt;
        return $this;
    }
}
