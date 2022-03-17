<?php

namespace App\Entity;

use App\Repository\TransporteursRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'transporteur', targetEntity: Commandes::class)]
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

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
            $commande->setTransporteur($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getTransporteur() === $this) {
                $commande->setTransporteur(null);
            }
        }

        return $this;
    }
}
