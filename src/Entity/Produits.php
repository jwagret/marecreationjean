<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToMany(targetEntity: Commandes::class, mappedBy: 'produits')]
    private $commandes;

    #[ORM\ManyToOne(targetEntity: Categories::class, inversedBy: 'produits')]
    private $categorie;

    #[ORM\ManyToMany(targetEntity: Reductions::class, mappedBy: 'produits')]
    private $reductions;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Images::class)]
    private $images;

    #[ORM\ManyToMany(targetEntity: Tissus::class, mappedBy: 'produits')]
    private $tissuses;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Stocks::class)]
    private $stocks;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->reductions = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->tissuses = new ArrayCollection();
        $this->stocks = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Commandes>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commandes $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeProduit($this);
        }

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Reductions>
     */
    public function getReductions(): Collection
    {
        return $this->reductions;
    }

    public function addReduction(Reductions $reduction): self
    {
        if (!$this->reductions->contains($reduction)) {
            $this->reductions[] = $reduction;
            $reduction->addProduit($this);
        }

        return $this;
    }

    public function removeReduction(Reductions $reduction): self
    {
        if ($this->reductions->removeElement($reduction)) {
            $reduction->removeProduit($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProduit($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduit() === $this) {
                $image->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tissus>
     */
    public function getTissuses(): Collection
    {
        return $this->tissuses;
    }

    public function addTissus(Tissus $tissus): self
    {
        if (!$this->tissuses->contains($tissus)) {
            $this->tissuses[] = $tissus;
            $tissus->addProduit($this);
        }

        return $this;
    }

    public function removeTissus(Tissus $tissus): self
    {
        if ($this->tissuses->removeElement($tissus)) {
            $tissus->removeProduit($this);
        }

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
            $stock->setProduit($this);
        }

        return $this;
    }

    public function removeStock(Stocks $stock): self
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getProduit() === $this) {
                $stock->setProduit(null);
            }
        }

        return $this;
    }


    //toString
    public function __toString(): string
    {
       return $this->getProduitNom();
    }
}
