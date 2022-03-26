<?php

namespace App\Controller\Admin;

use App\Entity\Clients;


use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CrudClientController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->doctrine = $managerRegistry->getManager()->getRepository(Clients::class);
    }


    #[Route('/admin/clients', name: 'app_admin_crud_client')]
    public function index(): Response
    {
        $clients = $this->doctrine->findAll();

        return $this->render('admin/crud_client/clients.html.twig', [
            'liste_clients' => $clients
        ]);
    }
}
