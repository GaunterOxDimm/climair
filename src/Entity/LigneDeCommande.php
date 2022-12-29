<?php

namespace App\Entity;

use App\Repository\LigneDeCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneDeCommandeRepository::class)]
class LigneDeCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'ligneDeCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?commande $integre = null;

    #[ORM\OneToOne(inversedBy: 'ligneDeCommande', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?prestation $correspond = null;

    #[ORM\OneToOne(mappedBy: 'correspondance', cascade: ['persist', 'remove'])]
    private ?Article $article = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getIntegre(): ?commande
    {
        return $this->integre;
    }

    public function setIntegre(?commande $integre): self
    {
        $this->integre = $integre;

        return $this;
    }

    public function getCorrespond(): ?prestation
    {
        return $this->correspond;
    }

    public function setCorrespond(prestation $correspond): self
    {
        $this->correspond = $correspond;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        // unset the owning side of the relation if necessary
        if ($article === null && $this->article !== null) {
            $this->article->setCorrespondance(null);
        }

        // set the owning side of the relation if necessary
        if ($article !== null && $article->getCorrespondance() !== $this) {
            $article->setCorrespondance($this);
        }

        $this->article = $article;

        return $this;
    }
}
