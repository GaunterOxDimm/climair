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

    #[ORM\Column(length: 255)]
    private ?string $img_prestation = null;

    #[ORM\Column]
    private ?float $prix_prestation = null;

    #[ORM\OneToOne(mappedBy: 'correspond', cascade: ['persist', 'remove'])]
    private ?LigneDeCommande $ligneDeCommande = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_rdv = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getImgPrestation(): ?string
    {
        return $this->img_prestation;
    }

    public function setImgPrestation(string $img_prestation): self
    {
        $this->img_prestation = $img_prestation;

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

    public function getLigneDeCommande(): ?LigneDeCommande
    {
        return $this->ligneDeCommande;
    }

    public function setLigneDeCommande(LigneDeCommande $ligneDeCommande): self
    {
        // set the owning side of the relation if necessary
        if ($ligneDeCommande->getCorrespond() !== $this) {
            $ligneDeCommande->setCorrespond($this);
        }

        $this->ligneDeCommande = $ligneDeCommande;

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
}
