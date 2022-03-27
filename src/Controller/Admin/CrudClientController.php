<?php

namespace App\Controller\Admin;

use App\Entity\Clients;


use App\Repository\AdressesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/clients', name: 'app_admin_crud_client_')]
class CrudClientController extends AbstractController
{
    private $doctrine;
    private AdressesRepository $adressesRepository;

    public function __construct(ManagerRegistry $managerRegistry, AdressesRepository $adressesRepository)
    {
        $this->doctrine = $managerRegistry->getManager()->getRepository(Clients::class);
        $this->adressesRepository = $adressesRepository;
    }


    #[Route('', name: 'liste')]
    public function index(): Response
    {
        $clients = $this->doctrine->findAll();

        return $this->render('admin/crud_client/clients.html.twig', [
            'liste_clients' => $clients
        ]);
    }


    #[Route('/details/{id<\d+>}', name: 'details')]
    public function detailsClient(int $id): Response
    {

        $client = $this->doctrine->findOneBy(['id' => $id]);
        $mesAdresses = $this->adressesRepository->mesAdresses($client);

        return $this->render('admin/crud_client/clientsDetails.html.twig', [
            'adminClientCourant' => $client,
            'adminClientCourantAdresses' => $mesAdresses
        ]);
    }


}
