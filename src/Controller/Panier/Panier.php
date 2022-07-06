<?php

namespace App\Controller\Panier;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;

class Panier
{
    private $session;
    private $doctrine;

    public function __construct(RequestStack $session, ManagerRegistry $managerRegistry)
    {
        $this->session = $session->getSession();
        $this->doctrine = $managerRegistry->getManager();
    }


    //Ajouter un produit dans le panier = session
    public function ajouterPanier(int $id) {
        //Créer la session
        $panier = $this->session->get('panier', []);

        //Vérifier si un produit existe déjà => augmenter la quantité
        if (!empty($panier[$id])){
            $panier[$id]++;
        }else {
            //sinon reste à 1 quantité
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    //Ajouter un produit unique dans le panier = session
    public function ajouterPanierUnique(int $id) {
        //créer la session
        $panier = $this->session->get('panier', []);

        //Si panier vide tu ajoutes un produit unique
        if (empty($panier[$id])){
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }


    //Retirer un produit dans le panier = session
    public function retirerPanier(int $id) {
        //Créer la session
        $panier = $this->session->get('panier', []);

        //Vérifier si un produit existe déjà => augmenter la quantité
        if ($panier[$id] > 1){
            $panier[$id]--;
        }else {
            //sinon détruire la variable
           unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    //Supprimer un produit
    public function supprimerProduit($id) {
        //Créer la session
        $panier = $this->session->get('panier', []);

        //Détruire l'id
        unset($panier[$id]);

        //Mettre à jour le panier
        $this->session->set('panier', $panier);
    }

    //Supprimer tout le panier
    public function viderPanier() {
        return $this->session->remove('panier');
    }

    //Afficher le panier
    public function afficherPanier() {
        return $this->session->get('panier');
    }

    //Afficher tout le panier
    public function afficherToutPanier() {
        $panierComplet = [];
        if ($this->afficherPanier()) {
            foreach ($this->afficherPanier() as $id => $quantite) {
                $produit = $this->doctrine->getRepository(Produits::class)->findOneBy(['id' => $id]);
                $produit->setQuantite($quantite);
                //Si le produit n'existe pas
                if (!$produit){
                    $this->supprimerProduit($id);
                    //Sort de la boucle et continue le fonctionnement normal
                    continue;
                }
                $panierComplet[] = [
                    'produit' => $produit,
                    'totalPrixQuantite' => $produit->getProduitPrix() * $produit->getQuantite()
                ];
            }
        }
        return $panierComplet;
    }



}