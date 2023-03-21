<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_article = null;

    #[ORM\Column]
    private ?float $prix_article = null;

    #[ORM\Column(length: 255)]
    private ?string $img_article = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_article = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: LigneDeCommande::class)]
    private Collection $ligneDeCommande;

    #[ORM\ManyToOne(inversedBy: 'article')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategorieArticle $categorieArticle = null;

    #[ORM\Column(nullable: true)]
    private ?int $stock = null;

    #[ORM\Column(nullable: true)]
    private ?bool $heart = null;

    public function __construct()
    {
        $this->ligneDeCommande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }
    public function __toString(): string
    {
        return $this->nom_article . ' ' . $this->prix_article . ' ' .
            $this->img_article . ' ' . $this->description_article;
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
        return $this->prix_article / 100;
    }

    public function setPrixArticle(float $prix_article): self
    {
        $this->prix_article = $prix_article * 100;

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

    /**
     * @return Collection<int, LigneDeCommande>
     */
    public function getLigneDeCommande(): Collection
    {
        return $this->ligneDeCommande;
    }

    public function addLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if (!$this->ligneDeCommande->contains($ligneDeCommande)) {
            $this->ligneDeCommande->add($ligneDeCommande);
            $ligneDeCommande->setArticle($this);
        }

        return $this;
    }

    public function removeLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if ($this->ligneDeCommande->removeElement($ligneDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneDeCommande->getArticle() === $this) {
                $ligneDeCommande->setArticle(null);
            }
        }

        return $this;
    }

    public function getCategorieArticle(): ?CategorieArticle
    {
        return $this->categorieArticle;
    }

    public function setCategorieArticle(?CategorieArticle $categorieArticle): self
    {
        $this->categorieArticle = $categorieArticle;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function isHeart(): ?bool
    {
        return $this->heart;
    }

    public function setHeart(?bool $heart): self
    {
        $this->heart = $heart;

        return $this;
    }
}
