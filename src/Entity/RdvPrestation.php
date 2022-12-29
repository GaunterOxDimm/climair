<?php

namespace App\Entity;

use App\Repository\RdvPrestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RdvPrestationRepository::class)]
class RdvPrestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_rdv = null;

    #[ORM\ManyToMany(targetEntity: Prestation::class, mappedBy: 'programmer')]
    private Collection $prestations;

    #[ORM\ManyToOne(inversedBy: 'rdvprestations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?utilisateur $prendre_rdv = null;

    public function __construct()
    {
        $this->prestations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Prestation>
     */
    public function getPrestations(): Collection
    {
        return $this->prestations;
    }

    public function addPrestation(Prestation $prestation): self
    {
        if (!$this->prestations->contains($prestation)) {
            $this->prestations->add($prestation);
            $prestation->addProgrammer($this);
        }

        return $this;
    }

    public function removePrestation(Prestation $prestation): self
    {
        if ($this->prestations->removeElement($prestation)) {
            $prestation->removeProgrammer($this);
        }

        return $this;
    }

    public function getPrendreRdv(): ?utilisateur
    {
        return $this->prendre_rdv;
    }

    public function setPrendreRdv(?utilisateur $prendre_rdv): self
    {
        $this->prendre_rdv = $prendre_rdv;

        return $this;
    }
}
