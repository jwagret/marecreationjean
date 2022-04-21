<?php

namespace App\Controller\Admin;

use App\Entity\Stocks;
use App\Entity\Tissus;
use App\Form\Stocks\StocksType;
use App\Repository\StocksRepository;
use App\Utils\Outils\Outils;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin/crud/stock', name: 'app_admin_crud_stock_')]
class CrudStockController extends AbstractController
{

    private $doctrine;
    private StocksRepository $stocksRepository;

    public function __construct( ManagerRegistry $managerRegistry, StocksRepository $stocksRepository)
    {
        $this->doctrine = $managerRegistry->getManager();
        $this->stocksRepository = $stocksRepository;
    }

    #[Route('', name: 'liste')]
    public function index(): Response
    {
        $liste_stock = $this->stocksRepository->findAll();
        $total = count($liste_stock);


        return $this->render('admin/crud_stock/index.html.twig', [
            'liste_stocks' => $liste_stock,
            'total_stocks' => $total
        ]);
    }

    //Ajouter un stock
    #[Route('/ajouter', name: 'ajouter')]
    public function ajouterStock(Request $request): Response {
        $date = Outils::creerDate('d/m/Y');
        $stock = new Stocks();
        $formStock = $this->createForm(StocksType::class, $stock);
        $formStock->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            $this->addFlash('no-success', 'Action annulée');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($formStock->isSubmitted() && $formStock->isValid()) {

            if ($btnValider) {
                $stock->setDateCreation($date);
                $stock->setStockReference($formStock->get('stock_reference')->getData());
                $stock->setStockDesignation($formStock->get('stock_designation')->getData());
                $stock->setStockQuantite($formStock->get('stock_quantite')->getData());
                $stock->setTissu($formStock->get('tissu')->getData());
                $stock->setProduit($formStock->get('produit')->getData());
                $stock->setIsStockRupture(false);
                $this->doctrine->persist($stock);
                $this->doctrine->flush();

                $this->addFlash('success', 'Le stock est bien enregistrée');
                return $this->redirectToRoute('app_admin_dashboard');
            }
        }

        return $this->render('admin/crud_stock/ajouter.html.twig', [
            'formStock' => $formStock->createView(),
            'nomFormulaire' => 'ajouter'
        ]);
    }
}
