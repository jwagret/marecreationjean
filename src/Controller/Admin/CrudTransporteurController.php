<?php

namespace App\Controller\Admin;

use App\Entity\Transporteurs;
use App\Form\Transporteur\TransporteurType;
use App\Repository\TransporteursRepository;
use App\Utils\Outils\Outils;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $total = count($transporteurs);

        return $this->render('admin/crud_transporteur/index.html.twig', [
            'liste_transporteurs' => $transporteurs,
            'total_transporteurs' => $total
        ]);
    }

    //Details d'un transporteur
    #[Route('/details/{id<\d+>}', name: 'details')]
    public function details(int $id): Response
    {
        $transporteur = $this->transporteursRepository->findOneBy(['id' => $id]);

        if (!$transporteur) {
            return $this->render('admin/crud_transporteur/index.html.twig');
        }

        return $this->render('admin/crud_transporteur/details.html.twig', [
            'transporteur' => $transporteur
        ]);
    }

    //Ajouter un transporteur
    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(Request $request): Response
    {
        $date = Outils::creerDate('d/m/Y');
        $transporteur = new Transporteurs();
        $formTransporteur = $this->createForm(TransporteurType::class, $transporteur);
        $formTransporteur->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            $this->addFlash('no-success', 'Action annulée');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($formTransporteur->isSubmitted() && $formTransporteur->isValid()) {
            if ($btnValider) {
                $transporteur->setDateCreation($date);
                $transporteur->setTransporteurNom($formTransporteur->get('transporteur_nom')->getData());
                $transporteur->setTransporteurPrix($formTransporteur->get('transporteur_prix')->getData());

                $this->doctrine->persist($transporteur);
                $this->doctrine->flush();

                $this->addFlash('success', 'Le transporteur est bien enregistrée');
                return $this->redirectToRoute('app_admin_dashboard');
            }
        }

        return $this->render('admin/crud_transporteur/ajouter.html.twig', [
            'formTransporteur' => $formTransporteur->createView(),
            'nomFormulaire' => 'ajouter'
        ]);
    }

    //Modifier un transporteur
    #[Route('/modifier/{id<\d+>}', name: 'modifier')]
    public function modifier(Request $request, int $id): Response
    {
        $date = Outils::creerDate('d/m/Y');
        $transporteur = $this->transporteursRepository->findOneBy(['id' => $id]);
        $formTransporteur = $this->createForm(TransporteurType::class, $transporteur);
        $formTransporteur->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            $this->addFlash('no-success', 'Action annulée');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($formTransporteur->isSubmitted() && $formTransporteur->isValid()) {
            if ($btnValider) {
                $transporteur->setDateModification($date);
                $transporteur->setTransporteurNom($formTransporteur->get('transporteur_nom')->getData());
                $transporteur->setTransporteurPrix($formTransporteur->get('transporteur_prix')->getData());

                $this->doctrine->flush();

                $this->addFlash('success', 'Le transporteur est bien enregistrée');
                return $this->redirectToRoute('app_admin_dashboard');
            }
        }

        return $this->render('admin/crud_transporteur/ajouter.html.twig', [
            'formTransporteur' => $formTransporteur->createView(),
            'nomFormulaire' => 'modifier'
        ]);
    }

    //Supprimer un transporteur
    #[Route('/supprimer/{id<\d+>}', name: 'supprimer')]
    public function supprimer(int $id): Response
    {
        $transporteur = $this->transporteursRepository->findOneBy(['id' => $id]);

        if (!$transporteur) {
            $this->addFlash('no-success', "le transporteur n'existe pas !!");
            return $this->redirectToRoute('app_admin_crud_transporteur_liste');
        }

        $this->doctrine->remove($transporteur);
        $this->doctrine->flush();
        $this->addFlash('success', 'Le transporteur est bien supprimée');
        return $this->redirectToRoute('app_admin_crud_transporteur_liste');
    }








}
