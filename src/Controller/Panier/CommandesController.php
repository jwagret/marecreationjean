<?php

namespace App\Controller\Panier;

use App\Entity\Commandes;
use App\Entity\Produits;
use App\Entity\Transporteurs;
use App\Repository\ClientsRepository;
use App\Repository\CommandesRepository;
use App\Repository\TransporteursRepository;
use App\Utils\Outils\Outils;
use App\Utils\References\Reference;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier', name: 'app_panier_')]
class CommandesController extends AbstractController
{
    private $doctrine;
    private TransporteursRepository $transport;
    private CommandesRepository $commande;
    private ClientsRepository $clients;

    public function __construct( ManagerRegistry $managerRegistry, TransporteursRepository $transporteursRepository, CommandesRepository $commandesRepository, ClientsRepository $clientsRepository)
    {
        $this->doctrine = $managerRegistry->getManager();
        $this->transport = $transporteursRepository;
        $this->commande = $commandesRepository;
        $this->clients = $clientsRepository;
    }

    #[Route('', name: 'commandes')]
    public function index(Panier $panier): Response
    {
        $transports = $this->transport->findAll();
        $courant = null;

        foreach ($transports as $transportCourant) {
            if ($transportCourant->getIsActif()) {
                $courant = $transportCourant;
            } else {
                $courant = $transportCourant->setTransporteurPrix(0.00);
            }
        }

        return $this->render('panier/commandes/index.html.twig', [
            'liste_panier' => $panier->afficherToutPanier(),
            'transportActif' => $courant
        ]);
    }

    //Ajouter un produit
    #[Route('/ajouter/{id<\d+>}', name: 'ajouter')]
    public function ajouter(Panier $panier, int $id): Response {
        $panier->ajouterPanier($id);
        return $this->redirectToRoute('app_panier_commandes');
    }

    //Ajouter un produit unique
    #[Route('/ajouter/unique/{id<\d+>}', name: 'ajouterUnique')]
    public function ajouterUnique(Panier $panier, int $id) {
        $panier->ajouterPanierUnique($id);
        return $this->redirectToRoute('app_panier_commandes');
    }

    //Diminuer un produit
    #[Route('/retirer/{id<\d+>}', name: 'retirer')]
    public function retirer(Panier $panier, int $id): Response {
        $panier->retirerPanier($id);
        return $this->redirectToRoute('app_panier_commandes');
    }

    //Supprimer un panier
    #[Route('/supprimer/{id<\d+>}', name: 'supprimer')]
    public function supprimer(Panier $panier, int $id): Response {
        $panier->supprimerProduit($id);
        return $this->redirectToRoute('app_panier_commandes');
    }

    //Supprimer tout le panier
    #[Route('/vider', name: 'vider')]
    public function vider(Panier $panier): Response {
        $panier->viderPanier();
        return $this->redirectToRoute('app_panier_commandes');
    }

    //Afficher la commande à valider
    #[Route('/macommande', name: 'afficherCommande')]
    public function afficherCommande(Panier $panier) {

        $date = Outils::creerDate('d/m/Y');
        $annéeCommande = Outils::creerDate('d/m/Y');
        $user =Outils::verifierUser($this->getUser(), $this->redirectToRoute('app_logout'));

        //Récupérer l'utilisateur connecté
        $clientCourant = $this->clients->findOneBy(['utilisateur' => $user]);

        //Créer la commande
        $commande = new Commandes();
        $produitCourant = new Produits();
        $transport = $this->transport->findBy(['isActif' => 1]);

        foreach ($panier->afficherToutPanier() as $item) {
            $produitCourant = $item["produit"];
            $commande->addProduit($produitCourant);
       }

        //Constituer la commande
        $refCommande = new Reference();
        $commande->setCommandeReference($refCommande->referenceCommande());
        $commande->setClient($clientCourant);
        $commande->setDateCreation($date);
        $commande->setAnneeCommande($annéeCommande->format('Y'));
        $produitCourant->addCommande($commande);
        $clientCourant->addCommande($commande);

        //Parcourir le tableau des transports et récupérer le transport actif
        //Ajouter la commande au transporteur
        foreach ($transport as $item) {
            $item->addCommande($commande);
        }

        //Sauvegarder
        $this->doctrine->persist($commande);
        $this->doctrine->persist($produitCourant);
        $this->doctrine->flush();

        return $this->render('panier/commandes/details.html.twig', [
            'commande' => $commande
        ]);
    }
}
