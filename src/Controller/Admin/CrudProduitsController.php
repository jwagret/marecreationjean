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

    //Afficher tous les produits
    #[Route('', name: 'liste')]
    public function index(): Response
    {
        $produits = $this->produitsRepository->findAll();

        return $this->render('admin/crud_produits/index.html.twig', [
            'liste_produits' => $produits
        ]);
    }

    //Détailler un produit
    #[Route('/details/{id<\d+>}', name: 'details')]
    public function detailProduit(int $id): Response
    {
        $produit = $this->produitsRepository->findOneBy(['id' => $id]);
        return $this->render('admin/crud_produits/details.html.twig', [
            'produit' => $produit
        ]);
    }

    //Ajouter un produit
    #[Route('/ajout', name: 'ajout_produit')]
    public function creerProduit(Request $request): Response
    {

        $date = Outils::creerDate('d/m/y');

        //Créer un nouveau produit
        $produit = new Produits();
        $produit->setDateCreation($date);
        $produit->setIsProduitVendu(false);

        //Créer le formulaire
        $formProduit = $this->createForm(ProduitType::class, $produit);
        $formProduit->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            $this->addFlash('no-success', 'Action annulée');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($formProduit->isSubmitted() && $formProduit->isValid()) {
            if ($btnValider) {
                $produit->setProduitReference($formProduit->get('produit_reference')->getData());
                $produit->setProduitNom($formProduit->get('produit_nom')->getData());
                $produit->setProduitDesignation($formProduit->get('produit_designation')->getData());
                $produit->setProduitPrix($formProduit->get('produit_prix')->getData());
                $produit->addReduction($formProduit->get('reductions')->getData());
                $produit->setCategorie($formProduit->get('categorie')->getData());
                $produit->addTissus($formProduit->get('tissuses')->getData());

                $this->doctrine->persist($produit);
                $this->doctrine->flush();

                $this->addFlash('success', 'Le produit est bien enregistré');
                return $this->redirectToRoute('app_admin_crud_produits_liste');
            }
        }

        return $this->render('admin/crud_produits/ajoutProduit.html.twig', [
            'formProduit' => $formProduit->createView(),
            'nomFormulaire' => 'ajouter'
        ]);
    }

    //Modifier un produit
    #[Route('/modifier/{id<\d+>}', name: 'modifier_produit')]
    public function modifierProduit(Request $request, int $id): Response
    {
        $date = Outils::creerDate('d/m/y');
        $produit = $this->produitsRepository->findOneBy(['id' => $id]);

        if (!$produit) {
            $this->addFlash('no-success', "le produit n'existe pas !!");
            return $this->redirectToRoute('app_admin_crud_reductions_liste');
        }

        $produit->setDateModification($date);

        //Créer le formulaire
        $formProduit = $this->createForm(ProduitType::class, $produit);
        $formProduit->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            $this->addFlash('no-success', 'Action annulée');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($formProduit->isSubmitted() && $formProduit->isValid()) {
            if ($btnValider) {
                $produit->setProduitReference($formProduit->get('produit_reference')->getData());
                $produit->setProduitNom($formProduit->get('produit_nom')->getData());
                $produit->setProduitDesignation($formProduit->get('produit_designation')->getData());
                $produit->setProduitPrix($formProduit->get('produit_prix')->getData());
                $produit->addReduction($formProduit->get('reductions')->getData());
                $produit->setCategorie($formProduit->get('categorie')->getData());
                $produit->addTissus($formProduit->get('tissuses')->getData());

                $this->doctrine->flush();
                $this->addFlash('success', 'Le produit est bien enregistré');

                return $this->redirectToRoute('app_admin_crud_produits_liste');
            }
        }

        return $this->render('admin/crud_produits/ajoutProduit.html.twig', [
            'formProduit' => $formProduit->createView(),
            'nomFormulaire' => 'modifier'
        ]);
    }

    //Supprimer un produit
    #[Route('/supprimer/{id<\d+>}', name: 'supprimer_produit')]
    public function supprimer(int $id): Response
    {
        $produit = $this->produitsRepository->findOneBy(['id' => $id]);

        if (!$produit) {
            $this->addFlash('no-success', "le produit n'existe pas !!");
            return $this->redirectToRoute('app_admin_crud_reductions_liste');
        }

        $this->doctrine->remove($produit);
        $this->doctrine->flush();
        $this->addFlash('success', 'Le produit est bien supprimée');
        return $this->redirectToRoute('app_admin_crud_produits_liste');
    }
}
