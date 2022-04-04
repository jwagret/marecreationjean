<?php

namespace App\Controller\Admin;

use App\Entity\Tissus;
use App\Repository\TissusRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/crud/tissus', name: 'app_admin_crud_tissus_')]
class CrudTissusController extends AbstractController
{
    private $doctrine;
    private TissusRepository $tissusRepository;

    public function __construct(ManagerRegistry $managerRegistry, TissusRepository $tissusRepository)
    {
        $this->doctrine = $managerRegistry->getManager();
        $this->tissusRepository = $tissusRepository;
    }

    #[Route('', name: 'liste')]
    public function index(): Response
    {
        $tissus = $this->tissusRepository->findAll();
        return $this->render('admin/crud_tissus/index.html.twig', [
            'liste_tissus' => $tissus
        ]);
    }

    //Details d'un tissus
    #[Route('details/{id<\d+>}', name: 'details')]
    public function details(int $id):Response {
        $tissus = $this->tissusRepository->findOneBy(['id' => $id]);

        if (!$tissus) {
            return $this->render('admin/crud_tissus/index.html.twig');
        }

        return $this->render('admin/crud_tissus/details.html.twig', [
            'tissus' => $tissus
        ]);
    }

    //Ajouter un tissus

}
