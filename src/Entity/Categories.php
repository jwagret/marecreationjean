<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    use TraitDate;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $categorie_nom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorieNom(): ?string
    {
        return $this->categorie_nom;
    }

    public function setCategorieNom(string $categorie_nom): self
    {
        $this->categorie_nom = $categorie_nom;

        return $this;
    }
}
