<?php

namespace App\Entity;

use App\Repository\PrestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestationRepository::class)]
class Prestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_prestation = null;

    #[ORM\Column]
    private ?float $prix_prestation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_rdv = null;

    #[ORM\OneToMany(mappedBy: 'prestation', targetEntity: LigneDeCommande::class)]
    private Collection $lignedecommande;

    public function __construct()
    {
        $this->lignedecommande = new ArrayCollection();
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
        return $this->id . ' ' . $this->description_prestation
            . ' ' . $this->prix_prestation;
    }
    public function getDescriptionPrestation(): ?string
    {
        return $this->description_prestation;
    }

    public function setDescriptionPrestation(string $description_prestation): self
    {
        $this->description_prestation = $description_prestation;

        return $this;
    }

    public function getPrixPrestation(): ?float
    {
        return $this->prix_prestation;
    }

    public function setPrixPrestation(float $prix_prestation): self
    {
        $this->prix_prestation = $prix_prestation;

        return $this;
    }

    public function getDateRdv(): ?\DateTimeInterface
    {
        return $this->date_rdv;
    }

    public function setDateRdv(\DateTimeInterface $date_rdv): self
    {
        $this->date_rdv = $date_rdv;

        return $this;
    }

    /**
     * @return Collection<int, LigneDeCommande>
     */
    public function getLignedecommande(): Collection
    {
        return $this->lignedecommande;
    }

    public function addLignedecommande(LigneDeCommande $lignedecommande): self
    {
        if (!$this->lignedecommande->contains($lignedecommande)) {
            $this->lignedecommande->add($lignedecommande);
            $lignedecommande->setPrestation($this);
        }

        return $this;
    }

    public function removeLignedecommande(LigneDeCommande $lignedecommande): self
    {
        if ($this->lignedecommande->removeElement($lignedecommande)) {
            // set the owning side to null (unless already changed)
            if ($lignedecommande->getPrestation() === $this) {
                $lignedecommande->setPrestation(null);
            }
        }

        return $this;
    }
}
