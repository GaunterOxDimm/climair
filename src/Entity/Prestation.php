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

    #[ORM\OneToMany(mappedBy: 'prestation', targetEntity: LigneDeCommande::class)]
    private Collection $lignedecommande;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img_prestation = null;

    #[ORM\OneToMany(mappedBy: 'prestation', targetEntity: Rdv::class)]
    private Collection $rdvs;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    public function __construct()
    {
        $this->lignedecommande = new ArrayCollection();
        $this->rdvs = new ArrayCollection();
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
            . ' ' . $this->prix_prestation . ' ' . $this->nom;
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

    public function getImgPrestation(): ?string
    {
        return $this->img_prestation;
    }

    public function setImgPrestation(?string $img_prestation): self
    {
        $this->img_prestation = $img_prestation;

        return $this;
    }

    /**
     * @return Collection<int, Rdv>
     */
    public function getRdvs(): Collection
    {
        return $this->rdvs;
    }
    public function setRdvs(): Collection
    {
        return $this->rdvs;
    }

    // public function addRdv(Rdv $rdv): self
    // {
    //     if (!$this->rdvs->contains($rdv)) {
    //         $this->rdvs->add($rdv);
    //         $rdv->setPrestation($this);
    //     }

    //     return $this;
    // }

    // public function removeRdv(Rdv $rdv): self
    // {
    //     if ($this->rdvs->removeElement($rdv)) {
    //         // set the owning side to null (unless already changed)
    //         if ($rdv->getPrestation() === $this) {
    //             $rdv->setPrestation(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
}
