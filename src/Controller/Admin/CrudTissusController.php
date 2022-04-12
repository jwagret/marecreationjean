<?php

namespace App\Controller\Admin;

use App\Entity\Tissus;
use App\Form\Tissus\TissusType;
use App\Repository\TissusRepository;
use App\Utils\Outils\Outils;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/details/{id<\d+>}', name: 'details')]
    public function details(int $id): Response
    {
        $tissus = $this->tissusRepository->findOneBy(['id' => $id]);

        if (!$tissus) {
            return $this->render('admin/crud_tissus/index.html.twig');
        }

        return $this->render('admin/crud_tissus/details.html.twig', [
            'tissus' => $tissus
        ]);
    }

    //Ajouter un tissus
    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(Request $request): Response
    {
        $date = Outils::creerDate('d/m/Y');
        $tissus = new Tissus();
        $formTissus = $this->createForm(TissusType::class, $tissus);
        $formTissus->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            $this->addFlash('no-success', 'Action annulée');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($formTissus->isSubmitted() && $formTissus->isValid()) {
            if ($btnValider) {
                $tissus->setDateCreation($date);
                $tissus->setTissuNom($formTissus->get('tissu_nom')->getData());
                $tissus->setTissusDesignation($formTissus->get('tissus_designation')->getData());
                $tissus->setTissuTarif($formTissus->get('tissu_tarif')->getData());

                $this->doctrine->persist($tissus);
                $this->doctrine->flush();

                $this->addFlash('success', 'Le tissus est bien enregistrée');
                return $this->redirectToRoute('app_admin_dashboard');
            }
        }

        return $this->render('admin/crud_tissus/ajouter.html.twig', [
            'formTissus' => $formTissus->createView(),
            'nomFormulaire' => 'ajouter'
        ]);
    }

    //Modifier un tissus
    #[Route('/modifier/{id<\d+>}', name: 'modifier')]
    public function modifier(Request $request, int $id): Response
    {
        $date = Outils::creerDate('d/m/Y');
        $tissus = $this->tissusRepository->findOneBy(['id' => $id]);
        $formTissus = $this->createForm(TissusType::class, $tissus);
        $formTissus->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            $this->addFlash('no-success', 'Action annulée');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($formTissus->isSubmitted() && $formTissus->isValid()) {
            if ($btnValider) {
                $tissus->setDateModification($date);
                $tissus->setTissuNom($formTissus->get('tissu_nom')->getData());
                $tissus->setTissusDesignation($formTissus->get('tissus_designation')->getData());
                $tissus->setTissuTarif($formTissus->get('tissu_tarif')->getData());

                $this->doctrine->flush();
                $this->addFlash('success', 'Le tissus a bien été modifié');

                return $this->redirectToRoute('app_admin_dashboard');
            }
        }

        return $this->render('admin/crud_tissus/ajouter.html.twig', [
            'formTissus' => $formTissus->createView(),
            'nomFormulaire' => 'modifier'
        ]);
    }

    //Supprimer un tissus
    #[Route('/supprimer/{id<\d+>}', name: 'supprimer')]
    public function supprimer(int $id): Response
    {
        $tissus = $this->tissusRepository->findOneBy(['id' => $id]);

        if (!$tissus) {
            $this->addFlash('no-success', "le tissus n'existe pas !!");
            return $this->redirectToRoute('app_admin_crud_tissus_liste');
        }

        $this->doctrine->remove($tissus);
        $this->doctrine->flush();
        $this->addFlash('success', 'Le tissus est bien supprimée');
        return $this->redirectToRoute('app_admin_crud_tissus_liste');
    }
}
