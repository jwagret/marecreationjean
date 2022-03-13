<?php

namespace App\Entity;

use App\Repository\TissusRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TissusRepository::class)]
class Tissus
{

    use TraitDate;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $tissu_nom;

    #[ORM\Column(type: 'text')]
    private $tissus_designation;

    #[ORM\Column(type: 'float')]
    private $tissu_tarif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTissuNom(): ?string
    {
        return $this->tissu_nom;
    }

    public function setTissuNom(string $tissu_nom): self
    {
        $this->tissu_nom = $tissu_nom;

        return $this;
    }

    public function getTissusDesignation(): ?string
    {
        return $this->tissus_designation;
    }

    public function setTissusDesignation(string $tissus_designation): self
    {
        $this->tissus_designation = $tissus_designation;

        return $this;
    }

    public function getTissuTarif(): ?float
    {
        return $this->tissu_tarif;
    }

    public function setTissuTarif(float $tissu_tarif): self
    {
        $this->tissu_tarif = $tissu_tarif;

        return $this;
    }
}
