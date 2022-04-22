<?php

namespace App\Entity;

use App\Repository\TissusRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(type: 'float', scale: '2')]
    private $tissu_tarif;

    #[ORM\ManyToMany(targetEntity: Produits::class, inversedBy: 'tissuses')]
    private $produits;

    #[ORM\OneToMany(mappedBy: 'tissu', targetEntity: Stocks::class)]
    private $stocks;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->stocks = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Produits>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produits $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Produits $produit): self
    {
        $this->produits->removeElement($produit);

        return $this;
    }

    /**
     * @return Collection<int, Stocks>
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stocks $stock): self
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks[] = $stock;
            $stock->setTissu($this);
        }

        return $this;
    }

    public function removeStock(Stocks $stock): self
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getTissu() === $this) {
                $stock->setTissu(null);
            }
        }

        return $this;
    }
}
