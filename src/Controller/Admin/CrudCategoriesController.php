<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\Categorie\CategoriesType;
use App\Repository\CategoriesRepository;
use App\Utils\Outils\Outils;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/crud/categories', name: 'app_admin_crud_categories_')]
class CrudCategoriesController extends AbstractController
{

    private $doctrine;
    private CategoriesRepository $categoriesRepository;

    public function __construct(ManagerRegistry $managerRegistry, CategoriesRepository $categoriesRepository)
    {
        $this->doctrine = $managerRegistry->getManager();
        $this->categoriesRepository = $categoriesRepository;
    }


    //Afficher toutes les catégories
    #[Route('', name: 'liste')]
    public function index(): Response
    {
        $categories = $this->categoriesRepository->findAll();

        return $this->render('admin/crud_categories/index.html.twig', [
            'liste_categories' => $categories
        ]);
    }

    //Détails de la catégorie
    #[Route('/details/{id<\d+>}', name: 'details')]
    public function detailsCategorie(int $id): Response
    {
        $categorie = $this->categoriesRepository->findOneBy(['id' => $id]);
        return $this->render('admin/crud_categories/details.html.twig', [
            'categorie' => $categorie
        ]);
    }


    //Ajouter une catégorie
    #[Route('/ajouter', name: 'ajouter_categories')]
    public function ajouterCategorie(Request $request): Response
    {

        $date = Outils::creerDate('d/m/Y');
        $categorie = new Categories();

        $formCategorie = $this->createForm(CategoriesType::class, $categorie);
        $formCategorie->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($formCategorie->isSubmitted() && $formCategorie->isValid()) {
            if ($btnValider) {
                $categorie->setCategorieNom($formCategorie->get('categorie_nom')->getData());
                $categorie->setDateCreation($date);

                $this->doctrine->persist($categorie);
                $this->doctrine->flush();

                $this->addFlash('success', 'La catégorie est bien enregistrée');
                return $this->redirectToRoute('app_admin_dashboard');
            }
        }

        return $this->render('admin/crud_categories/ajoutCategorie.html.twig', [
            'formCategorie' => $formCategorie->createView(),
            'nomFormulaire' => 'ajouter'
        ]);
    }

    //Modifier une catégorie
    #[Route('/modifier/{id<\d+>}', name: 'modifier_categorie')]
    public function modifierCategorie(Request $request, int $id): Response
    {
        $date = Outils::creerDate('d/m/Y');
        $categorie = $this->categoriesRepository->findOneBy(['id' => $id]);

        $formCategorie = $this->createForm(CategoriesType::class, $categorie);
        $formCategorie->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($formCategorie->isSubmitted() && $formCategorie->isValid()) {
            if ($btnValider) {
                $categorie->setCategorieNom($formCategorie->get('categorie_nom')->getData());
                $categorie->setDateModification($date);

                $this->doctrine->flush();

                $this->addFlash('success', 'La catégorie est bien modifiée');
                return $this->redirectToRoute('app_admin_dashboard');
            }
        }

        return $this->render('admin/crud_categories/ajoutCategorie.html.twig', [
            'formCategorie' => $formCategorie->createView(),
            'nomFormulaire' => 'modifier'
        ]);
    }

    //todo faire la suppression d'une categorie






}
