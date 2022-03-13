<?php

namespace App\Entity;

use App\Repository\FacturesRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturesRepository::class)]
class Factures
{

    use TraitDate;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $facture_date;

    #[ORM\Column(type: 'string', length: 255)]
    private $facture_numero;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFactureDate(): ?\DateTimeInterface
    {
        return $this->facture_date;
    }

    public function setFactureDate(\DateTimeInterface $facture_date): self
    {
        $this->facture_date = $facture_date;

        return $this;
    }

    public function getFactureNumero(): ?string
    {
        return $this->facture_numero;
    }

    public function setFactureNumero(string $facture_numero): self
    {
        $this->facture_numero = $facture_numero;

        return $this;
    }
}
