<?php

namespace App\Utils\References;

class Reference
{
    private $tab;
    private $numFacture = 0;

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
        return $prenom[0]. $nom[0].'-'.date('Y').$this->tab[random_int(0, 25)]. $this->tab[random_int(0, 25)]. $this->tab[random_int(0, 25)].'-'.random_int(0, 9999). $this->tab[random_int(0, 25)];
    }

//    public function referenceFacture() {
//        return "Facture: F".date('dmY').$this->tab[random_int(0, 25)]. $this->tab[random_int(0, 25)]. $this->tab[random_int(0, 25)].'-'.$this->numFacture. $this->tab[random_int(0, 25)];
//    }

}