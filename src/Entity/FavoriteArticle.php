<?php

namespace App\Entity;

use App\Repository\FavoriteArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteArticleRepository::class)]
class FavoriteArticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?int $userId = null;

    #[ORM\Column]
    private ?int $articleId = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?bool $saved = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getArticleId(): ?int
    {
        return $this->articleId;
    }

    public function setArticleId(int $articleId): static
    {
        $this->articleId = $articleId;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function isSaved(): ?bool
    {
        return $this->saved;
    }

    public function setSaved(bool $saved): static
    {
        $this->saved = $saved;

        return $this;
    }
}
