<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'application_')]
class HomeController extends AbstractController
{
    private ProduitsRepository $produitsRepository;

    public function __construct(ProduitsRepository $produitsRepository)
    {
        $this->produitsRepository = $produitsRepository;
    }


    #[Route('', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    //liste des produits
    #[Route('listeProduits', name: 'listeProduits')]
    public function listeProduits(): Response {
        $listeProduits = $this->produitsRepository->findAll();

        return $this->render('home/listeProduits.html.twig', [
            'liste_produits' => $listeProduits
        ]);
    }

    //voir un produit
    #[Route('/details/{id<\d+>}', name: 'details')]
    public function details(int $id): Response {

        $produit = $this->produitsRepository->findOneBy(['id' => $id]);

        if (!$produit) {
            $this->addFlash('no-success', "le produit n'existe pas !!");
            return $this->redirectToRoute('application_listeProduits');
        }

        return $this->render('home/detail.html.twig', [
            'produit' => $produit
        ]);
    }






}
