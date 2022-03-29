<?php

namespace App\Controller\Admin;

use App\Entity\Transporteurs;
use App\Repository\TransporteursRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/crud/transporteur', name: 'app_admin_crud_transporteur_')]
class CrudTransporteurController extends AbstractController
{
    private $doctrine;
    private TransporteursRepository $transporteursRepository;

    public function __construct(ManagerRegistry $managerRegistry, TransporteursRepository $transporteursRepository)
    {
        $this->doctrine = $managerRegistry->getManager();
        $this->transporteursRepository = $transporteursRepository;
    }


    #[Route('', name: 'liste')]
    public function index(): Response
    {
        $transporteurs = $this->transporteursRepository->findAll();

        return $this->render('admin/crud_transporteur/index.html.twig', [
            'liste_transporteurs' => $transporteurs
        ]);
    }
}
