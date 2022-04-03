<?php

namespace App\Controller\Admin;

use App\Entity\Reductions;
use App\Form\Reductions\ReductionType;
use App\Repository\ReductionsRepository;
use App\Utils\Outils\Outils;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

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

    //Ajouter une reduction
    #[Route('/ajouter', name: 'ajouter_reduction')]
    public function ajouterReduction(Request $request): Response {
        $date = Outils::creerDate('d/m/Y');
        $reduction = new Reductions();

        $formReduction = $this->createForm(ReductionType::class, $reduction);
        $formReduction->handleRequest($request);

        if ($formReduction->isSubmitted() && $formReduction->isValid()) {
            $reduction->setDateCreation($date);
            $reduction->setReductionReference($formReduction->get('reduction_reference')->getData());
            $reduction->setReductionDesignation($formReduction->get('reduction_designation')->getData());
            $reduction->setReductionPourcentage($formReduction->get('reduction_pourcentage')->getData());
            //$reduction->setReductionMontant($formReduction->get('reduction_montant')->getData());
            $reduction->setAnneeReductions($formReduction->get('anneeReductions')->getData());

            dd($reduction);

        }


        return $this->render('admin/crud_reductions/ajoutReduction.html.twig', [
                'formReduction' => $formReduction->createView(),
                'nomFormulaire' => 'ajouter'
        ]);

    }
}
