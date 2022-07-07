<?php

namespace App\Controller\Admin;

use App\Repository\CategoriesRepository;
use App\Repository\ClientsRepository;
use App\Repository\CommandesRepository;
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
    private CommandesRepository $commandesRepository;

    public function __construct(ProduitsRepository $produitsRepository,
                                ClientsRepository $clientsRepository,
                                CategoriesRepository $categoriesRepository,
                                SousCategoriesRepository $sousCategoriesRepository,
                                TransporteursRepository $transporteursRepository,
                                CommandesRepository $commandesRepository)
    {
        $this->produitsRepository = $produitsRepository;
        $this->clientsRepository = $clientsRepository;
        $this->categoriesRepository = $categoriesRepository;
        $this->sousCategoriesRepository = $sousCategoriesRepository;
        $this->transporteursRepository = $transporteursRepository;
        $this->commandesRepository = $commandesRepository;
    }


    #[Route('', name: 'dashboard')]
    public function index(): Response
    {
        //-1 pour le aucun (ex: aucun produit...)
        $totalProduits = $this->produitsRepository->totalProduits()-1;
        $totalClients = $this->clientsRepository->totalClients();
        $totalCategories = $this->categoriesRepository->totalCategories()-1;
        $totalSousCategories = $this->sousCategoriesRepository->totalSousCategories()-1;
        $totalTransporteur = $this->transporteursRepository->totalTransporteur();
        $totalCommandes = $this->commandesRepository->totalCommandes();

        return $this->render('admin/admin/admin.html.twig', [
            'total_produits' => $totalProduits,
            'total_clients' => $totalClients,
            'total_categories' => $totalCategories,
            'total_sousCategories' => $totalSousCategories,
            'total_transporteur' => $totalTransporteur,
            'total_commandes' => $totalCommandes
        ]);
    }



}
