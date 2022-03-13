<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitsRepository::class)]
class Produits
{

    use TraitDate;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $produit_reference;

    #[ORM\Column(type: 'string', length: 255)]
    private $produit_nom;

    #[ORM\Column(type: 'text')]
    private $produit_designation;

    #[ORM\Column(type: 'float')]
    private $produit_prix;

    #[ORM\Column(type: 'boolean')]
    private $is_produit_vendu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduitReference(): ?string
    {
        return $this->produit_reference;
    }

    public function setProduitReference(string $produit_reference): self
    {
        $this->produit_reference = $produit_reference;

        return $this;
    }

    public function getProduitNom(): ?string
    {
        return $this->produit_nom;
    }

    public function setProduitNom(string $produit_nom): self
    {
        $this->produit_nom = $produit_nom;

        return $this;
    }

    public function getProduitDesignation(): ?string
    {
        return $this->produit_designation;
    }

    public function setProduitDesignation(string $produit_designation): self
    {
        $this->produit_designation = $produit_designation;

        return $this;
    }

    public function getProduitPrix(): ?float
    {
        return $this->produit_prix;
    }

    public function setProduitPrix(float $produit_prix): self
    {
        $this->produit_prix = $produit_prix;

        return $this;
    }

    public function getIsProduitVendu(): ?bool
    {
        return $this->is_produit_vendu;
    }

    public function setIsProduitVendu(bool $is_produit_vendu): self
    {
        $this->is_produit_vendu = $is_produit_vendu;

        return $this;
    }
}
