<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column(length: 50)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'passer_commande', targetEntity: Commande::class)]
    private Collection $commandes;

    #[ORM\OneToMany(mappedBy: 'prendre_rdv', targetEntity: Rdvprestation::class)]
    private Collection $rdvprestations;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->rdvprestations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setPasserCommande($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getPasserCommande() === $this) {
                $commande->setPasserCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Rdvprestation>
     */
    public function getRdvprestations(): Collection
    {
        return $this->rdvprestations;
    }

    public function addRdvprestation(Rdvprestation $rdvprestation): self
    {
        if (!$this->rdvprestations->contains($rdvprestation)) {
            $this->rdvprestations->add($rdvprestation);
            $rdvprestation->setPrendreRdv($this);
        }

        return $this;
    }

    public function removeRdvprestation(Rdvprestation $rdvprestation): self
    {
        if ($this->rdvprestations->removeElement($rdvprestation)) {
            // set the owning side to null (unless already changed)
            if ($rdvprestation->getPrendreRdv() === $this) {
                $rdvprestation->setPrendreRdv(null);
            }
        }

        return $this;
    }
}
