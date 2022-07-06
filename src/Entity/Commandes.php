<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandesRepository::class)]
class Commandes
{
    use TraitDate;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $commande_reference;

    #[ORM\ManyToOne(targetEntity: Clients::class, inversedBy: 'commandes')]
    private $client;

    #[ORM\ManyToMany(targetEntity: Produits::class, inversedBy: 'commandes')]
    private $produits;

    #[ORM\ManyToOne(targetEntity: Transporteurs::class, inversedBy: 'commandes')]
    private $transporteur;

    #[ORM\Column(type: 'string')]
    private $anneeCommande;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommandeReference(): ?string
    {
        return $this->commande_reference;
    }

    public function setCommandeReference(string $commande_reference): self
    {
        $this->commande_reference = $commande_reference;

        return $this;
    }

    public function getClient(): ?Clients
    {
        return $this->client;
    }

    public function setClient(?Clients $client): self
    {
        $this->client = $client;

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

    public function getTransporteur(): ?Transporteurs
    {
        return $this->transporteur;
    }

    public function setTransporteur(?Transporteurs $transporteur): self
    {
        $this->transporteur = $transporteur;

        return $this;
    }

    public function getAnneeCommande(): ?string
    {
        return $this->anneeCommande;
    }

    public function setAnneeCommande(string $anneeCommande): self
    {
        $this->anneeCommande = $anneeCommande;

        return $this;
    }
}
