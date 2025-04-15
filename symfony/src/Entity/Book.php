<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\ManyToOne(targetEntity: Author::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Author $author;

    #[ORM\Column(type: "date", nullable: true)]
    private ?\DateTimeInterface $publishedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getPublishedYear(): ?int
    {
        return $this->publishedAt;
    }

    public function setPublishedYear(?int $publishedAt): self
    {
        $this->publishedYear = $publishedAt;
        return $this;
    }
}
