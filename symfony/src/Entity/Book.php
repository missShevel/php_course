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

    #[ORM\ManyToOne(targetEntity: Author::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['issue:read', 'book:read'])]
    private Author $author;

    #[ORM\Column(type: "date", nullable: true)]
    #[Groups(['issue:read', 'book:read'])]
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

    public function getPublishedAt(): ?int
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?int $publishedAt): self
    {
        $this->publishedAt = $publishedAt;
        return $this;
    }
}
