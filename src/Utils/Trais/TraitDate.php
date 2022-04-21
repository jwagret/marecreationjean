<?php

namespace App\Utils\Trais;
use Doctrine\ORM\Mapping as ORM;

trait TraitDate
{
    #[ORM\Column(type: 'date')]
    private $dateCreation;

    #[ORM\Column(type: 'date', nullable: true)]
    private $dateModification;


    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     */
    public function setDateCreation($dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }


    /**
     * @return mixed
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * @param mixed $dateModification
     */
    public function setDateModification($dateModification): void
    {
        $this->dateModification = $dateModification;
    }


}