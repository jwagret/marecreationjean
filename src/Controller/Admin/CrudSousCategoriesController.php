<?php

namespace App\Controller\Admin;

use App\Entity\SousCategories;
use App\Form\SousCategorie\SousCategorieType;
use App\Repository\SousCategoriesRepository;
use App\Utils\Outils\Outils;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/crud/sous/categories', name: 'app_admin_crud_sous_categories_')]
class CrudSousCategoriesController extends AbstractController
{
    private $doctrine;
    private SousCategoriesRepository $sousCategoriesRepository;

    public function __construct(ManagerRegistry $managerRegistry, SousCategoriesRepository $sousCategoriesRepository)
    {
        $this->doctrine = $managerRegistry->getManager();
        $this->sousCategoriesRepository = $sousCategoriesRepository;
    }


    //Afficher toutes les sous-catégories
    #[Route('', name: 'liste')]
    public function index(): Response
    {
        $sousCategories = $this->sousCategoriesRepository->findAll();

        return $this->render('admin/crud_sous_categories/index.html.twig', [
            'liste_sousCategories' => $sousCategories
        ]);
    }

    //Détails d'une sous-catégorie
    #[Route('/details/{id<\d+>}', name: 'details_sous_categorie')]
    public function detailsSousCategorie(Request $request, int $id): Response
    {
        $sousCategorie = $this->sousCategoriesRepository->findOneBy(['id' => $id]);
        return $this->render('admin/crud_sous_categories/details.html.twig', [
            'sousCategorie' => $sousCategorie
        ]);
    }

    //Ajouter une sous-catégorie
    #[Route('/ajouter', name: 'ajouter_sousCategorie')]
    public function ajouterSousCategorie(Request $request): Response
    {
        $date = Outils::creerDate('d/m/Y');
        $sousCategorie = new SousCategories();

        $formSousCategorie = $this->createForm(SousCategorieType::class, $sousCategorie);
        $formSousCategorie->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            $this->addFlash('no-success', 'Action annulée');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($formSousCategorie->isSubmitted() && $formSousCategorie->isValid()) {

            if ($btnValider) {
                $sousCategorie->setDateCreation($date);
                $sousCategorie->setSousCategorieNom($formSousCategorie->get('sousCategorie_nom')->getData());
                $sousCategorie->setCategorie($formSousCategorie->get('categorie')->getData());
                $categorie = $sousCategorie->getCategorie();
                $categorie->addSousCategory($sousCategorie);

                $this->doctrine->persist($sousCategorie);
                $this->doctrine->flush();

                $this->addFlash('success', 'La sous-catégorie est bien enregistrée');
                return $this->redirectToRoute('app_admin_dashboard');
            }
        }

        return $this->render('admin/crud_sous_categories/ajoutSousCategorie.html.twig', [
            'formSousCategorie' => $formSousCategorie->createView(),
            'nomFormulaire' => 'ajouter'
        ]);
    }

    //Supprimer une sous-catégorie
}
