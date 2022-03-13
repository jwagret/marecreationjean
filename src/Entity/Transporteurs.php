<?php

namespace App\Entity;

use App\Repository\TransporteursRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransporteursRepository::class)]
class Transporteurs
{
    use TraitDate;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $transporteur_nom;

    #[ORM\Column(type: 'float')]
    private $transporteur_prix;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransporteurNom(): ?string
    {
        return $this->transporteur_nom;
    }

    public function setTransporteurNom(string $transporteur_nom): self
    {
        $this->transporteur_nom = $transporteur_nom;

        return $this;
    }

    public function getTransporteurPrix(): ?float
    {
        return $this->transporteur_prix;
    }

    public function setTransporteurPrix(float $transporteur_prix): self
    {
        $this->transporteur_prix = $transporteur_prix;

        return $this;
    }
}
