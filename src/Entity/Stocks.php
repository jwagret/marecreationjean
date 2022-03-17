<?php

namespace App\Entity;

use App\Repository\StocksRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StocksRepository::class)]
class Stocks
{

    use TraitDate;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $stock_reference;

    #[ORM\Column(type: 'text')]
    private $stock_designation;

    #[ORM\Column(type: 'integer')]
    private $stock_quantite;

    #[ORM\Column(type: 'boolean')]
    private $is_stock_rupture;

    #[ORM\ManyToOne(targetEntity: Tissus::class, inversedBy: 'stocks')]
    private $tissu;

    #[ORM\ManyToOne(targetEntity: Produits::class, inversedBy: 'stocks')]
    private $produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStockReference(): ?string
    {
        return $this->stock_reference;
    }

    public function setStockReference(string $stock_reference): self
    {
        $this->stock_reference = $stock_reference;

        return $this;
    }

    public function getStockDesignation(): ?string
    {
        return $this->stock_designation;
    }

    public function setStockDesignation(string $stock_designation): self
    {
        $this->stock_designation = $stock_designation;

        return $this;
    }

    public function getStockQuantite(): ?int
    {
        return $this->stock_quantite;
    }

    public function setStockQuantite(int $stock_quantite): self
    {
        $this->stock_quantite = $stock_quantite;

        return $this;
    }

    public function getIsStockRupture(): ?bool
    {
        return $this->is_stock_rupture;
    }

    public function setIsStockRupture(bool $is_stock_rupture): self
    {
        $this->is_stock_rupture = $is_stock_rupture;

        return $this;
    }

    public function getTissu(): ?Tissus
    {
        return $this->tissu;
    }

    public function setTissu(?Tissus $tissu): self
    {
        $this->tissu = $tissu;

        return $this;
    }

    public function getProduit(): ?Produits
    {
        return $this->produit;
    }

    public function setProduit(?Produits $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
}
