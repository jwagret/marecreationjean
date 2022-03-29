<?php

namespace App\Controller\Admin;

use App\Entity\Reductions;
use App\Repository\ReductionsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/crud/reductions', name: 'app_admin_crud_reductions_')]
class CrudReductionsController extends AbstractController
{
    private $doctrine;
    private ReductionsRepository $reductionsRepository;

    public function __construct(ManagerRegistry $managerRegistry, ReductionsRepository $reductionsRepository)
    {
        $this->doctrine = $managerRegistry->getManager();
        $this->reductionsRepository = $reductionsRepository;
    }

    #[Route('', name: 'liste')]
    public function index(): Response
    {
        $reductions = $this->reductionsRepository->findAll();

        return $this->render('admin/crud_reductions/index.html.twig', [
            'liste_reductions' => $reductions
        ]);
    }
}
