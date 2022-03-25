<?php

namespace App\Entity;

use App\Repository\ArchiverFacturesRepository;
use App\Utils\Trais\TraitDate;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArchiverFacturesRepository::class)]
class ArchiverFactures
{
    use TraitDate;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $archiverFacture_numero;

    #[ORM\OneToMany(mappedBy: 'archiverFactures', targetEntity: Factures::class)]
    private $facture;

    #[ORM\Column(type: 'date')]
    private $anneeArchive;

    public function __construct()
    {
        $this->facture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArchiverFactureNumero(): ?string
    {
        return $this->archiverFacture_numero;
    }

    public function setArchiverFactureNumero(string $archiverFacture_numero): self
    {
        $this->archiverFacture_numero = $archiverFacture_numero;

        return $this;
    }

    /**
     * @return Collection<int, Factures>
     */
    public function getFacture(): Collection
    {
        return $this->facture;
    }

    public function addFacture(Factures $facture): self
    {
        if (!$this->facture->contains($facture)) {
            $this->facture[] = $facture;
            $facture->setArchiverFactures($this);
        }

        return $this;
    }

    public function removeFacture(Factures $facture): self
    {
        if ($this->facture->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getArchiverFactures() === $this) {
                $facture->setArchiverFactures(null);
            }
        }

        return $this;
    }

    public function getAnneeArchive(): ?\DateTimeInterface
    {
        return $this->anneeArchive;
    }

    public function setAnneeArchive(\DateTimeInterface $anneeArchive): self
    {
        $this->anneeArchive = $anneeArchive;

        return $this;
    }
}
