<?php

namespace App\Utils\References;

class Reference
{
    private $tab;
    private $numFacture = 10;
    private $numCommande = 20;

    public function __construct()
    {
        $this->tab = [
            'A','B','C','D','E',
            'F','G','H','I','J',
            'K','L','M','N','O',
            'P','Q','R','S','T',
            'U','V','W','X','Y',
            'Z'
        ];
    }


    public function referenceClient($prenom, $nom): string
    {
        return strtoupper($prenom[0]). strtoupper($nom[0]).'-'.date('Y').$this->tab[random_int(0, 25)]. $this->tab[random_int(0, 25)]. $this->tab[random_int(0, 25)].'-'.random_int(0, 9999). $this->tab[random_int(0, 25)];
    }

    public function referenceFacture(): string {
        return "Facture: F".date('dmY').$this->tab[random_int(0, 25)]. $this->tab[random_int(0, 25)]. $this->tab[random_int(0, 25)].'-'.$this->numFacture. $this->tab[random_int(0, 25)];
    }

    public function referenceCommande(): string {
        return "Commande: C".date('dmY').$this->tab[random_int(0, 25)]. $this->tab[random_int(0, 25)]. $this->tab[random_int(0, 25)].'-'.$this->numCommande. $this->tab[random_int(0, 25)];
    }

}