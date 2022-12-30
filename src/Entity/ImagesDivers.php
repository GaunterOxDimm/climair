<?php

namespace App\Entity;

use App\Repository\ImagesDiversRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesDiversRepository::class)]
class ImagesDivers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_image = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse_image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomImage(): ?string
    {
        return $this->nom_image;
    }

    public function setNomImage(string $nom_image): self
    {
        $this->nom_image = $nom_image;

        return $this;
    }

    public function getAdresseImage(): ?string
    {
        return $this->adresse_image;
    }

    public function setAdresseImage(string $adresse_image): self
    {
        $this->adresse_image = $adresse_image;

        return $this;
    }
}
