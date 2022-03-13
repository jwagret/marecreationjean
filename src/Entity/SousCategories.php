<?php

namespace App\Entity;

use App\Repository\SousCategoriesRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousCategoriesRepository::class)]
class SousCategories
{
    use TraitDate;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $sousCategorie_nom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSousCategorieNom(): ?string
    {
        return $this->sousCategorie_nom;
    }

    public function setSousCategorieNom(string $sousCategorie_nom): self
    {
        $this->sousCategorie_nom = $sousCategorie_nom;

        return $this;
    }
}
