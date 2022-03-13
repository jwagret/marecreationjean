<?php

namespace App\Entity;

use App\Repository\AdressesRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdressesRepository::class)]
class Adresses
{
    use TraitDate;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    private $adresse_numero;

    #[ORM\Column(type: 'text')]
    private $adresse_rue;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresse_codepostale;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresse_ville;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresse_pays;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $adresse_type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresseNumero(): ?string
    {
        return $this->adresse_numero;
    }

    public function setAdresseNumero(string $adresse_numero): self
    {
        $this->adresse_numero = $adresse_numero;

        return $this;
    }

    public function getAdresseRue(): ?string
    {
        return $this->adresse_rue;
    }

    public function setAdresseRue(string $adresse_rue): self
    {
        $this->adresse_rue = $adresse_rue;

        return $this;
    }

    public function getAdresseCodepostale(): ?string
    {
        return $this->adresse_codepostale;
    }

    public function setAdresseCodepostale(string $adresse_codepostale): self
    {
        $this->adresse_codepostale = $adresse_codepostale;

        return $this;
    }

    public function getAdresseVille(): ?string
    {
        return $this->adresse_ville;
    }

    public function setAdresseVille(string $adresse_ville): self
    {
        $this->adresse_ville = $adresse_ville;

        return $this;
    }

    public function getAdressePays(): ?string
    {
        return $this->adresse_pays;
    }

    public function setAdressePays(string $adresse_pays): self
    {
        $this->adresse_pays = $adresse_pays;

        return $this;
    }

    public function getAdresseType(): ?string
    {
        return $this->adresse_type;
    }

    public function setAdresseType(?string $adresse_type): self
    {
        $this->adresse_type = $adresse_type;

        return $this;
    }
}
