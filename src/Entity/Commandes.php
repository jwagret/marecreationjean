<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use App\Utils\Trais\TraitDate;
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
}
