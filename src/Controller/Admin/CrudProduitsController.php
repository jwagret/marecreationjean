<?php

namespace App\Controller\Admin;

use App\Entity\Produits;
use App\Form\Produits\ProduitType;
use App\Repository\ProduitsRepository;
use App\Utils\Outils\Outils;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/produits', name: 'app_admin_crud_produits_')]
class CrudProduitsController extends AbstractController
{
    private $doctrine;
    private ProduitsRepository $produitsRepository;

    public function __construct(ManagerRegistry $managerRegistry, ProduitsRepository $produitsRepository)
    {
        $this->doctrine = $managerRegistry->getManager();
        $this->produitsRepository = $produitsRepository;
    }

    #[Route('', name: 'liste')]
    public function index(): Response
    {
        $produits = $this->produitsRepository->findAll();

        return $this->render('admin/crud_produits/index.html.twig', [
            'liste_produits' => $produits
        ]);
    }


    #[Route('/ajout', name: 'ajout_produit')]
    public function creerProduit(Request $request) : Response {

        $date = Outils::creerDate('d/m/y');

        //Créer un nouveau produit
        $produit = new Produits();
        $produit->setDateCreation($date);

        //Créer le formulaire
        $formProduit = $this->createForm(ProduitType::class,$produit);
        $formProduit->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        //todo creer le formulaire et la sauvegarde

        return $this->render('admin/crud_produits/ajoutProduit.html.twig', [
            'formProduit' => $formProduit->createView(),
            'nomFormulaire' => 'ajouter'
        ]);
    }
}
