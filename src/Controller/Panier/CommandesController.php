<?php

namespace App\Controller\Panier;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier', name: 'app_panier_')]
class CommandesController extends AbstractController
{
    private $doctrine;

    public function __construct( ManagerRegistry $managerRegistry)
    {
        $this->doctrine = $managerRegistry->getManager();
    }

    #[Route('', name: 'commandes')]
    public function index(Panier $panier): Response
    {
        return $this->render('panier/commandes/index.html.twig', [
            'liste_panier' => $panier->afficherToutPanier()
        ]);
    }

    //Ajouter un produit
    #[Route('/ajouter/{id<\d+>}', name: 'ajouter')]
    public function ajouter(Panier $panier, int $id): Response {
        $panier->ajouterPanier($id);
        return $this->redirectToRoute('app_panier_commandes');
    }

    //Ajouter un produit unique
    #[Route('/ajouter/unique/{id<\d+>}', name: 'ajouterUnique')]
    public function ajouterUnique(Panier $panier, int $id) {
        $panier->ajouterPanierUnique($id);
        return $this->redirectToRoute('app_panier_commandes');
    }

    //Diminuer un produit
    #[Route('/retirer/{id<\d+>}', name: 'retirer')]
    public function retirer(Panier $panier, int $id): Response {
        $panier->retirerPanier($id);
        return $this->redirectToRoute('app_panier_commandes');
    }

    //Supprimer un panier
    #[Route('/supprimer/{id<\d+>}', name: 'supprimer')]
    public function supprimer(Panier $panier, int $id): Response {
        $panier->supprimerProduit($id);
        return $this->redirectToRoute('app_panier_commandes');
    }

    //Supprimer tout le panier
    #[Route('/vider', name: 'vider')]
    public function vider(Panier $panier): Response {
        $panier->viderPanier();
        return $this->redirectToRoute('app_panier_commandes');
    }
}
