<?php

namespace App\Controller\EspaceClient;

use App\Form\Client\ChangerMotDePasseType;
use App\Form\Client\ClientType;
use App\Repository\ClientsRepository;
use App\Utils\Outils\Outils;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/espace/client', name: 'app_espace_client_')]
class ClientController extends AbstractController
{
    private $doctrine;
    private ClientsRepository $clientsRepository;

    public function __construct(ManagerRegistry $managerRegistry, ClientsRepository $clientsRepository)
    {
        $this->doctrine = $managerRegistry->getManager();
        $this->clientsRepository = $clientsRepository;
    }


    #[Route('/details', name: 'details')]
    public function index(): Response
    {
        return $this->render('espace_client/client/index.html.twig');
    }


    //Variable identique à ceux du twig
    #[Route('/modifier', name: 'modifier')]
    public function modifierInformation(Request $request): Response
    {
        $date = Outils::creerDate('d/m/y');
        $user =Outils::verifierUser($this->getUser(), $this->redirectToRoute('app_logout'));

        //Récupérer l'utilisateur connecté
        $clientCourant = $this->clientsRepository->findOneBy(['utilisateur' => $user]);

        //Création du formulaire
        $form = $this->createForm(ClientType::class, $clientCourant);
        $form->handleRequest($request);

        //Vérifier si le bouton est cliquer => Peut utiliser aussi le request->get('nomDuBouton)
        //Donner un name='monBouton' dans le formulaire ou le twig
        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            //Message Flash
            $this->addFlash('no-success', 'Annuler');
            return $this->redirectToRoute('app_espace_client');
        }

            //Soummettre et valider le formulaire
            if ($form->isSubmitted() && $form->isValid()) {
                if ($btnValider) {
                    //Mise à jour de la date de modification
                    $clientCourant->setDateModification($date);
                    $clientCourant->getUtilisateur()->setDateModification($clientCourant->getDateModification());
                    $clientCourant->setPseudo($form->get('pseudo')->getData());
                    $clientCourant->getUtilisateur()->setPseudo($clientCourant->getPseudo());
                    $clientCourant->setClientNom($form->get('client_nom')->getData());
                    $clientCourant->setClientPrenom($form->get('client_prenom')->getData());
                    $clientCourant->getUtilisateur()->setEmail($form->get('email')->getData());

                    $this->doctrine->flush();
                    //Message Flash
                    $this->addFlash('no-success', 'Valider : modifications validées');
                    return $this->redirectToRoute('app_espace_client');
                 }
            }

        return $this->render('espace_client/client/index.html.twig', [
            'clientCourant' => $clientCourant,
            'formModifClient' => $form->createView()
        ]);
    }


    //Modifier le mot de passe
    #[Route('/modifier/password', name: 'password')]
    public function changerPassword(Request $request, UserPasswordHasherInterface $userPasswordHasher) : Response {

        $date = Outils::creerDate('d/m/y');
        $user =Outils::verifierUser($this->getUser(), $this->redirectToRoute('app_logout'));

        //Récupérer l'utilisateur connecté avec le compte client
        $clientCourant = $this->clientsRepository->findOneBy(['utilisateur' => $user]);

        //Variable identique à ceux du twig
        $clientCourant->setDateModification($date);
        $clientCourant->getUtilisateur()->setDateModification($clientCourant->getDateModification());
        //Recuperation du mot de passe actuel
        $actualPassword = $clientCourant->getUtilisateur()->getPassword();

        //Creation du formulaire
        $formPassword = $this->createForm(ChangerMotDePasseType::class, $clientCourant->getUtilisateur());
        $formPassword->handleRequest($request);

        ///Recuperer le mot de passe entrer
        $actualPasswordFormulaire = $formPassword->get('oldPasse')->getData();

        //Vérifier si le bouton est cliquer => Peut utiliser aussi le request->get('nomDuBouton)
        //Donner un name='monBouton' dans le formulaire ou le twig
        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            //Message Flash
            $this->addFlash('no-success', 'Annuler');
            return $this->redirectToRoute('app_espace_client');
        }

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            if ($btnValider) {
                //Vérifier l'ancien mot de passe avec celui entrer dans le formulaire (mot de passe actuel)
                if (password_verify($actualPasswordFormulaire, $actualPassword) != true) {
                    //Message Flash
                    $this->addFlash('no-success', 'Annuler : Erreur mot de passe actuel');

                } else {
                    //Récupération du nouveau mot de passe
                    $newPassword = $formPassword->get('password')->getData();
                    //Vérifier que le nouveau mot de passe est différent de l'ancien
                    if (password_verify($newPassword, $actualPassword) != true) {
                        //On crée le mot de passe et on le Hash
                        $encodePassword = $userPasswordHasher->hashPassword($clientCourant->getUtilisateur(), $newPassword);
                        //Mise à jour du password
                        $clientCourant->getUtilisateur()->setPassword($encodePassword);

                        //Valider les données
                        $this->doctrine->flush();
                        //Message Flash
                        $this->addFlash('success', 'Valider : Mot de passe à jour');
                        return $this->redirectToRoute('app_espace_client');

                    } else {
                        //Message Flash
                        $this->addFlash('no-success', 'Annuler : Erreur mot de passe actuel et le nouveau sont identiques!');
                    }
                }
            }
        }

        return $this->render('espace_client/client/motDePasse.html.twig', [
            'clientCourant' => $clientCourant,
           'formModifPassword' => $formPassword->createView()
        ]);
    }

// todo Supprimer le compte d'un client ou seulement le désactiver pour garder les factures?

}
