<?php

namespace App\Controller\Admin;

use App\Repository\CategoriesRepository;
use App\Repository\ClientsRepository;
use App\Repository\ProduitsRepository;
use App\Repository\SousCategoriesRepository;
use App\Repository\TransporteursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'app_admin_')]
class AdminController extends AbstractController
{
    private ProduitsRepository $produitsRepository;
    private ClientsRepository $clientsRepository;
    private CategoriesRepository $categoriesRepository;
    private SousCategoriesRepository $sousCategoriesRepository;
    private TransporteursRepository $transporteursRepository;

    public function __construct(ProduitsRepository $produitsRepository,
                                ClientsRepository $clientsRepository,
                                CategoriesRepository $categoriesRepository,
                                SousCategoriesRepository $sousCategoriesRepository,
                                TransporteursRepository $transporteursRepository)
    {
        $this->produitsRepository = $produitsRepository;
        $this->clientsRepository = $clientsRepository;
        $this->categoriesRepository = $categoriesRepository;
        $this->sousCategoriesRepository = $sousCategoriesRepository;
        $this->transporteursRepository = $transporteursRepository;
    }


    #[Route('', name: 'dashboard')]
    public function index(): Response
    {
        $totalProduits = $this->produitsRepository->totalProduits();
        $totalClients = $this->clientsRepository->totalClients();
        $totalCategories = $this->categoriesRepository->totalCategories();
        $totalSousCategories = $this->sousCategoriesRepository->totalSousCategories();
        $totalTransporteur = $this->transporteursRepository->totalTransporteur();

        return $this->render('admin/admin/admin.html.twig', [
            'total_produits' => $totalProduits,
            'total_clients' => $totalClients,
            'total_categories' => $totalCategories,
            'total_sousCategories' => $totalSousCategories,
            'total_transporteur' => $totalTransporteur
        ]);
    }



}
