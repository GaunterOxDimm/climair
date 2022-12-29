<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_article = null;

    #[ORM\Column]
    private ?float $prix_article = null;

    #[ORM\Column(length: 255)]
    private ?string $img_article = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_article = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?categoriearticle $appartenir = null;

    #[ORM\OneToOne(inversedBy: 'article', cascade: ['persist', 'remove'])]
    private ?lignedecommande $correspondance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomArticle(): ?string
    {
        return $this->nom_article;
    }

    public function setNomArticle(string $nom_article): self
    {
        $this->nom_article = $nom_article;

        return $this;
    }

    public function getPrixArticle(): ?float
    {
        return $this->prix_article;
    }

    public function setPrixArticle(float $prix_article): self
    {
        $this->prix_article = $prix_article;

        return $this;
    }

    public function getImgArticle(): ?string
    {
        return $this->img_article;
    }

    public function setImgArticle(string $img_article): self
    {
        $this->img_article = $img_article;

        return $this;
    }

    public function getDescriptionArticle(): ?string
    {
        return $this->description_article;
    }

    public function setDescriptionArticle(string $description_article): self
    {
        $this->description_article = $description_article;

        return $this;
    }

    public function getAppartenir(): ?categoriearticle
    {
        return $this->appartenir;
    }

    public function setAppartenir(?categoriearticle $appartenir): self
    {
        $this->appartenir = $appartenir;

        return $this;
    }

    public function getCorrespondance(): ?lignedecommande
    {
        return $this->correspondance;
    }

    public function setCorrespondance(?lignedecommande $correspondance): self
    {
        $this->correspondance = $correspondance;

        return $this;
    }
}
