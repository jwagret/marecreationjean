<?php

namespace App\Entity;

use App\Repository\ArchiverFacturesRepository;
use App\Utils\Trais\TraitDate;
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
}
