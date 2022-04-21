<?php

namespace App\Controller\EspaceClient;

use App\Repository\ClientsRepository;
use App\Utils\Outils\Outils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/espace/client', name: 'app_espace_')]
class EspaceClientController extends AbstractController
{
    private $clientRepository;

    public function __construct(ClientsRepository $clientsRepository)
    {
        $this->clientRepository = $clientsRepository;
    }

    //Fait apparaître les informations du client et adresse dans l'espace client
    #[Route('', name: 'client')]
    public function index(): Response
    {
//        $date = Outils::creerDate('d/m/y');
        $user =Outils::verifierUser($this->getUser(), $this->redirectToRoute('app_login'));

        $clientCourant = $this->clientRepository->findOneBy(['utilisateur' => $user]);

        return $this->render('espace_client/espaceclient.html.twig', [
            'clientCourant' => $clientCourant
        ]);
    }

}
