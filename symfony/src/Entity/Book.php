<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[Groups(['issue:read', 'book:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['issue:read', 'book:read'])]
    private string $title;

    #[ORM\Column(length: 255)]
    #[Groups(['issue:read', 'book:read'])]
    private string $genre;

    #[ORM\ManyToOne(targetEntity: Author::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['issue:read', 'book:read'])]
    private Author $author;

    #[ORM\Column(type: "date", nullable: true)]
    #[Groups(['issue:read', 'book:read'])]
    private ?\DateTimeInterface $published_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;
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

    public function getPublishedAt(): ?\DateTime
    {
        return $this->published_at;
    }

    public function setPublishedAt(?DateTime $published_at): \DateTime
    {
        $this->published_at = $published_at;
        return $this;
    }
}
