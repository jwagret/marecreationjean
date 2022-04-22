<?php

namespace App\Entity;

use App\Repository\ReductionsRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReductionsRepository::class)]
class Reductions
{
    use TraitDate;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10)]
    private $reduction_reference;

    #[ORM\Column(type: 'text')]
    private $reduction_designation;

    #[ORM\Column(type: 'float', scale: '2')]
    private $reduction_pourcentage;

    #[ORM\Column(type: 'float', scale: '2')]
    private $reduction_montant;

    #[ORM\Column(type: 'string')]
    private $anneeReductions;

    #[ORM\ManyToMany(targetEntity: Produits::class, inversedBy: 'reductions')]
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReductionReference(): ?string
    {
        return $this->reduction_reference;
    }

    public function setReductionReference(string $reduction_reference): self
    {
        $this->reduction_reference = $reduction_reference;

        return $this;
    }

    public function getReductionDesignation(): ?string
    {
        return $this->reduction_designation;
    }

    public function setReductionDesignation(string $reduction_designation): self
    {
        $this->reduction_designation = $reduction_designation;

        return $this;
    }

    public function getReductionPourcentage(): ?float
    {
        return $this->reduction_pourcentage;
    }

    public function setReductionPourcentage(float $reduction_pourcentage): self
    {
        $this->reduction_pourcentage = $reduction_pourcentage;

        return $this;
    }

    public function getReductionMontant(): ?float
    {
        return $this->reduction_montant;
    }

    public function setReductionMontant(float $reduction_montant): self
    {
        $this->reduction_montant = $reduction_montant;

        return $this;
    }

    public function getAnneeReductions(): ?string
    {
        return $this->anneeReductions;
    }

    public function setAnneeReductions(string $anneeReductions): self
    {
        $this->anneeReductions = $anneeReductions;

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
}
