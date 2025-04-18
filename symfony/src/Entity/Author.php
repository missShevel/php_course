<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    /**
     * @Groups({"book:read", "author:read"})
     */
    private ?int $id = null;

    #[ORM\Column(length: 255)]
        /**
     * @Groups({"book:read", "author:read"})
     */
    private string $name;

    #[ORM\Column(type: "date", nullable: true)]
        /**
     * @Groups({"book:read", "author:read"})
     */
    private ?\DateTimeInterface $birthDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
{
    return $this->birthDate;
}

public function setBirthDate(\DateTimeInterface $birthDate): self
{
    $this->birthDate = $birthDate;
    return $this;
}

}
