<?php

namespace App\Controller\Admin;

use App\Entity\SousCategories;
use App\Repository\SousCategoriesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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


    #[Route('', name: 'liste')]
    public function index(): Response
    {
        $sousCategories = $this->sousCategoriesRepository->findAll();

        return $this->render('admin/crud_sous_categories/index.html.twig', [
            'liste_sousCategories' => $sousCategories
        ]);
    }
}
