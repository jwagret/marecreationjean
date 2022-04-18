<?php

namespace App\Controller\Admin;

use App\Repository\ClientsRepository;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'app_admin_')]
class AdminController extends AbstractController
{
    private ProduitsRepository $produitsRepository;
    private ClientsRepository $clientsRepository;

    public function __construct(ProduitsRepository $produitsRepository, ClientsRepository $clientsRepository)
    {
        $this->produitsRepository = $produitsRepository;
        $this->clientsRepository = $clientsRepository;
    }


    #[Route('', name: 'dashboard')]
    public function index(): Response
    {
        $totalProduits = $this->produitsRepository->totalProduits();
        $totalClients = $this->clientsRepository->totalClients();

        return $this->render('admin/admin/admin.html.twig', [
            'total_produits' => $totalProduits,
            'total_clients' => $totalClients,
        ]);
    }



}
