<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    use TraitDate;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $image_nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $image_chemin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageNom(): ?string
    {
        return $this->image_nom;
    }

    public function setImageNom(string $image_nom): self
    {
        $this->image_nom = $image_nom;

        return $this;
    }

    public function getImageChemin(): ?string
    {
        return $this->image_chemin;
    }

    public function setImageChemin(string $image_chemin): self
    {
        $this->image_chemin = $image_chemin;

        return $this;
    }
}
