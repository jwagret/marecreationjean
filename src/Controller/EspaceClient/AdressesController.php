<?php

namespace App\Controller\EspaceClient;

use App\Entity\Adresses;
use App\Form\Adresse\AdresseModifType;
use App\Form\Adresse\AdresseType;
use App\Repository\AdressesRepository;
use App\Repository\ClientsRepository;
use App\Utils\Outils\Outils;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/espace/client/adresse', name: 'app_espace_adresses_')]
class AdressesController extends AbstractController
{
    private $doctrine;
    private ClientsRepository $clientRepository;

    public function __construct(ManagerRegistry $managerRegistry, ClientsRepository $clientsRepository)
    {
        $this->doctrine = $managerRegistry->getManager();
        $this->clientRepository = $clientsRepository;
    }


    #[Route('/details', name: 'details')]
    public function index(): Response
    {
        return $this->render('espace_client/adresses/index.html.twig');
    }

    #[Route('/ajout/{id<\d+>}', name: 'ajout')]
    public function addAdresses(Request $request, int $id) : Response {

        $date = Outils::creerDate('d/m/y');
        $user =Outils::verifierUser($this->getUser(), $this->redirectToRoute('app_logout'));
        $desactiver = false;

        //Entité clients
        $clientCourant = $this->clientRepository->findOneBy(['utilisateur' => $user]);

        //Si l'identifiant id n'est pas identique à celui dans l'url on quitte l'application
        if ($clientCourant->getUtilisateur()->getId() !== $id) {
            return $this->redirectToRoute('app_logout');
        }

        //Adresse
        $monAdresse = new Adresses();
        $monAdresse->setDateCreation($date);

        $form_adresse = $this->createForm(AdresseType::class,$monAdresse);
        $form_adresse->handleRequest($request);

        $buttonValider = $request->get('btn_valider');
        $buttonAnnuler = $request->get('btn_annuler');

        if ($buttonAnnuler) {
            //Message flash
            $this->addFlash('no-success', 'Annuler');
            return $this->redirectToRoute('app_espace_client');
        }

        if ($form_adresse->isSubmitted() && $form_adresse->isValid() && $desactiver === false){
            if ($buttonValider) {
                //Lier le client aux adresses
                $clientCourant->addAdress($monAdresse);
                $monAdresse->setClient($clientCourant);

                $this->doctrine->persist($monAdresse);
                $this->doctrine->flush();

                //Message flash
                $this->addFlash('success', 'Valider : adresse enregistrée');
                return $this->redirectToRoute('app_espace_client');
            }
        }

        return $this->render('espace_client/adresses/index.html.twig', [
            'form_adresse' =>$form_adresse->createView(),
            'nomFormulaire' => 'ajouter',
            'desactiver' => $desactiver
        ]);
    }

    //Modifier une adresse
    #[Route('/modifier/{id<\d+>}', name: 'modifier')]
    public function modifierAdresse(Request $request, int $id):Response {
        $date = Outils::creerDate('d/m/y');
        $user =Outils::verifierUser($this->getUser(), $this->redirectToRoute('app_logout'));

        //Entité clients
        $clientCourant = $this->clientRepository->findOneBy(['utilisateur' => $user]);
        $listeAdresses = $clientCourant->getAdresses()->getValues();
        $itemCourant = null;
        $desactiver = false;

        //Parcours la liste des adresses pour récupérer l'adresse correspondant à l'id
        foreach ($listeAdresses as $adresse) {
            if ($adresse->getId() === $id) {
                $itemCourant = $adresse;
            }
        }

        //Si l'id ne correspond pas à ceux de la liste trouvé
        if ($itemCourant == null) {
            $desactiver = true;
        }

        $form_adresse = $this->createForm(AdresseModifType::class,$itemCourant, ['disabled' => $desactiver]);
        $form_adresse->handleRequest($request);

        $buttonValider = $request->get('btn_valider');
        $buttonAnnuler = $request->get('btn_annuler');

        if ($buttonAnnuler) {
            //Message flash
            $this->addFlash('no-success', 'Annuler');
            return $this->redirectToRoute('app_espace_client');
        }

        if ($form_adresse->isSubmitted() && $form_adresse->isValid() && $desactiver === false) {
            if ($buttonValider) {
                $itemCourant->setDateModification($date);
                $itemCourant->setAdresseNumero($form_adresse->get('adresse_numero')->getData());
                $itemCourant->setAdresseRue($form_adresse->get('adresse_rue')->getData());
                $itemCourant->setAdresseCodepostale($form_adresse->get('adresse_codepostale')->getData());
                $itemCourant->setAdresseVille($form_adresse->get('adresse_ville')->getData());
                $itemCourant->setAdressePays($form_adresse->get('adresse_pays')->getData());
                $itemCourant->setAdresseType($form_adresse->get('adresse_type')->getData());
                $this->doctrine->flush();

                //Message flash
                $this->addFlash('success', 'Valider : adresse modifiée');

                return $this->redirectToRoute('app_espace_client');
            }
        }

        return $this->render('espace_client/adresses/index.html.twig', [
            'form_adresse' =>$form_adresse->createView(),
            'nomFormulaire' => 'modifier',
            'desactiver' => $desactiver
        ]);
    }

    //Supprimer une adresse de la liste des adresses et du client correspondant
    #[Route('/supprimer/{id<\d+>}', name: 'supprimer', methods: ['GET', 'POST','DELETE'])]
    public function supprimerAdresse(int $id) :Response {
        $user =Outils::verifierUser($this->getUser(), $this->redirectToRoute('app_logout'));

        //Entité clients
        $clientCourant = $this->clientRepository->findOneBy(['utilisateur' => $user]);
        $listeAdresses = $clientCourant->getAdresses()->getValues();
        $itemCourant = null;

        //Parcours la liste des adresses pour récupérer l'adresse correspondant à l'id
        foreach ($listeAdresses as $adresse) {
            if ($adresse->getId() === $id) {
                $itemCourant = $adresse;
            }
        }

       //Retirer l'adresse de la liste d'adresses du client
       $clientCourant->removeAdress($itemCourant);

       //Supprimer de la base de données l'adresse courante
       $this->doctrine->remove($itemCourant);
       $this->doctrine->flush();

        //Message flash
        $this->addFlash('success', 'Valider : adresse supprimée');
       return $this->redirectToRoute('app_espace_client');
    }



}
