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

    //détails d'une réduction
    #[Route('/details/{id<\d+>}', name: 'details')]
    public function detailsReduction(int $id): Response {
        $reduction = $this->reductionsRepository->findOneBy(['id' => $id]);
        return $this->render('admin/crud_reductions/details.html.twig', [
            'reduction' => $reduction
        ]);
    }

    //Ajouter une reduction
    #[Route('/ajouter', name: 'ajouter')]
    public function ajouterReduction(Request $request): Response {
        $date = Outils::creerDate('d/m/Y');
        $reduction = new Reductions();

        $formReduction = $this->createForm(ReductionType::class, $reduction);
        $formReduction->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            $this->addFlash('no-success', 'Action annulée');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($formReduction->isSubmitted() && $formReduction->isValid()) {
            if ($btnValider) {
                $reduction->setDateCreation($date);
                $reduction->setReductionReference($formReduction->get('reduction_reference')->getData());
                $reduction->setReductionDesignation($formReduction->get('reduction_designation')->getData());
                $reduction->setReductionPourcentage($formReduction->get('reduction_pourcentage')->getData());
                $reduction->setReductionMontant($formReduction->get('reduction_montant')->getData());
                $reduction->setAnneeReductions($formReduction->get('anneeReductions')->getData());

                $this->doctrine->persist($reduction);
                $this->doctrine->flush();

                $this->addFlash('success', 'La réduction est bien enregistrée');
                return $this->redirectToRoute('app_admin_crud_reductions_liste');
            }
        }

        return $this->render('admin/crud_reductions/ajoutReduction.html.twig', [
                'formReduction' => $formReduction->createView(),
                'nomFormulaire' => 'ajouter'
        ]);

    }

    //Modifier une reduction
    #[Route('/modifier/{id<\d+>}', name: 'modifier')]
    public function modifierReduction(int $id, Request $request): Response {
        $date = Outils::creerDate('d/m/Y');
        $reduction = $this->reductionsRepository->findOneBy(['id' => $id]);

        $formReduction = $this->createForm(ReductionType::class, $reduction);
        $formReduction->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            $this->addFlash('no-success', 'Action annulée');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($formReduction->isSubmitted() && $formReduction->isValid()) {
            if ($btnValider) {
                $reduction->setDateModification($date);
                $reduction->setReductionReference($formReduction->get('reduction_reference')->getData());
                $reduction->setReductionDesignation($formReduction->get('reduction_designation')->getData());
                $reduction->setReductionPourcentage($formReduction->get('reduction_pourcentage')->getData());
                $reduction->setReductionMontant($formReduction->get('reduction_montant')->getData());
                $reduction->setAnneeReductions($formReduction->get('anneeReductions')->getData());

                $this->doctrine->flush();

                $this->addFlash('success', 'La réduction est bien modifiée');
                return $this->redirectToRoute('app_admin_crud_reductions_liste');
            }
        }

        return $this->render('admin/crud_reductions/ajoutReduction.html.twig', [
            'formReduction' => $formReduction->createView(),
            'nomFormulaire' => 'modifier'
        ]);
    }

    //Supprimer une reduction
    #[Route('/supprimer/{id<\d+>}', name: 'supprimer')]
    public function supprimer(int $id) :Response {
        $reduction = $this->reductionsRepository->findOneBy(['id' => $id]);

        if (!$reduction) {
            $this->addFlash('no-success', "la réduction n'existe pas !!");
            return $this->redirectToRoute('app_admin_crud_reductions_liste');
        }

        $this->addFlash('success', 'La réduction est bien supprimée');
        return $this->redirectToRoute('app_admin_crud_reductions_liste');
    }
}
