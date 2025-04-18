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

    public function getIssue(): ?Issue
    {
        return $this->issue;
    }

    public function setIssue(Issue $issue): self
    {
        $this->issue = $issue;
        return $this;
    }

    public function getReturnedAt(): ?\DateTimeInterface
    {
        return $this->returnedAt;
    }

    public function setReturnedAt(\DateTimeInterface $returnedAt): self
    {
        $this->returnedAt = $returnedAt;
        return $this;
    }
}
