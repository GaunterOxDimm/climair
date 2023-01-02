<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $total_commande = null;

    #[ORM\OneToMany(mappedBy: 'integre', targetEntity: LigneDeCommande::class)]
    private Collection $ligneDeCommandes;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Utilisateur $passer_commande = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_commande = null;

    public function __construct()
    {
        $this->ligneDeCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalCommande(): ?int
    {
        return $this->total_commande;
    }

    public function setTotalCommande(int $total_commande): self
    {
        $this->total_commande = $total_commande;

        return $this;
    }

    /**
     * @return Collection<int, LigneDeCommande>
     */
    public function getLigneDeCommandes(): Collection
    {
        return $this->ligneDeCommandes;
    }

    public function addLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if (!$this->ligneDeCommandes->contains($ligneDeCommande)) {
            $this->ligneDeCommandes->add($ligneDeCommande);
            $ligneDeCommande->setIntegre($this);
        }

        return $this;
    }

    public function removeLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        if ($this->ligneDeCommandes->removeElement($ligneDeCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneDeCommande->getIntegre() === $this) {
                $ligneDeCommande->setIntegre(null);
            }
        }

        return $this;
    }

    public function getPasserCommande(): ?Utilisateur
    {
        return $this->passer_commande;
    }

    public function setPasserCommande(?Utilisateur $passer_commande): self
    {
        $this->passer_commande = $passer_commande;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }
}
