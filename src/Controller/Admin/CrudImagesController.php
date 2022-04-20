<?php

namespace App\Controller\Admin;

use App\Entity\Images;
use App\Form\Images\ImagesType;
use App\Repository\ImagesRepository;
use App\Repository\ProduitsRepository;
use App\Utils\Outils\Outils;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/crud/images', name: 'app_admin_crud_images_')]
class CrudImagesController extends AbstractController
{
    private $doctrine;
    private ImagesRepository $imagesRepository;
    private ProduitsRepository $produitsRepository;
    private SluggerInterface $slugger;

    public function __construct(ManagerRegistry $managerRegistry, ImagesRepository $imagesRepository, SluggerInterface $sluggerInterface, ProduitsRepository $produitsRepository)
    {
        $this->doctrine = $managerRegistry->getManager();
        $this->imagesRepository = $imagesRepository;
        $this->produitsRepository = $produitsRepository;
        $this->slugger = $sluggerInterface;
    }

    //Afficher toutes les images
    #[Route('', name: 'liste')]
    public function index(): Response
    {
        $liste_images = $this->imagesRepository->findAll();
        $total = count($liste_images);

        return $this->render('admin/crud_images/index.html.twig', [
            'liste_images' => $liste_images,
            'total_images' => $total
        ]);
    }

    //Détailler une image
    #[Route('/details/{id<\d+>}', name: 'details')]
    public function detailImage(int $id): Response
    {
        $image = $this->imagesRepository->findOneBy(['id' => $id]);

        return $this->render('admin/crud_images/details.html.twig', [
            'image' => $image
        ]);
    }

    //Ajouter un produit
    #[Route('/ajout', name: 'ajout_images')]
    public function creerImage(Request $request): Response
    {

        $date = Outils::creerDate('d/m/y');

        //Créer une image
        $image = new Images();
        $image->setDateCreation($date);

        //Créer le formulaire
        $formImage = $this->createForm(ImagesType::class, $image);
        $formImage->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            $this->addFlash('no-success', 'Action annulée');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($formImage->isSubmitted() && $formImage->isValid()) {
            if ($btnValider) {
                $image->setImageNom($formImage->get('image_nom')->getData());

                /** @var UploadedFile $imageProduit */
                $imageProduit = $formImage->get('image_chemin')->getData();

                if ($imageProduit) {
                    //Renommer le fichier pour eviter les doublons
                    $original = pathinfo($imageProduit->getClientOriginalName(), PATHINFO_FILENAME);

                    //slugg
                    $nomImage = $this->slugger->slug($original);
                    $nouveauNom = $nomImage . '.' . $imageProduit->guessExtension();

                    try {
                        //Déplacer l'image
                        $imageProduit->move(
                            $this->getParameter('images_directory'),
                            $nouveauNom
                        );
                    } catch (FileException $e) {
                    }

                    $image->setImageChemin($nouveauNom);
                }

                $lienProduit = $image->setProduit($formImage->get('produit')->getData());

                $produit = $this->produitsRepository->findOneBy(['id' => $lienProduit->getProduit()->getId()]);
                $produit->addImage($image);

                $this->doctrine->persist($image);
                $this->doctrine->flush();

                $this->addFlash('success', "L'image est bien enregistré");
                return $this->redirectToRoute('app_admin_crud_images_liste');
            }
        }

        return $this->render('admin/crud_images/ajoutImages.html.twig', [
            'formImage' => $formImage->createView(),
            'nomFormulaire' => 'ajouter'
        ]);
    }

    //Modifier une image
    #[Route('/modifier/{id<\d+>}', name: 'modifier_images')]
    public function modifierImage(Request $request, int $id): Response {
        $date = Outils::creerDate('d/m/y');

        //Récupérer l'image
        $image = $this->imagesRepository->findOneBy(['id' => $id]);

        if (!$image) {
            $this->addFlash('no-success', "l'image n'existe pas !!");
            return $this->redirectToRoute('app_admin_crud_images_liste');
        }

        $image->setDateModification($date);

        //Créer le formulaire
        $formImage = $this->createForm(ImagesType::class, $image);
        $formImage->handleRequest($request);

        $btnValider = $request->get('btn_valider');
        $btnAnnuler = $request->get('btn_annuler');

        if ($btnAnnuler) {
            $this->addFlash('no-success', 'Action annulée');
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($formImage->isSubmitted() && $formImage->isValid()) {
            if ($btnValider) {
                $image->setImageNom($formImage->get('image_nom')->getData());

                /** @var UploadedFile $imageProduit */
                $imageProduit = $formImage->get('image_chemin')->getData();

                if ($imageProduit) {
                    //Renommer le fichier pour eviter les doublons
                    $original = pathinfo($imageProduit->getClientOriginalName(), PATHINFO_FILENAME);

                    //slugg
                    $nomImage = $this->slugger->slug($original);
                    $nouveauNom = $nomImage . '.' . $imageProduit->guessExtension();

                    try {
                        //Déplacer l'image
                        $imageProduit->move(
                            $this->getParameter('images_directory'),
                            $nouveauNom
                        );
                    } catch (FileException $e) {
                    }

                    $image->setImageChemin($nouveauNom);
                }

                $lienProduit = $image->setProduit($formImage->get('produit')->getData());
                $produit = $this->produitsRepository->findOneBy(['id' => $lienProduit->getProduit()->getId()]);
                $produit->addImage($image);

                $this->doctrine->flush();

                $this->addFlash('success', "L'image est bien modifiée");
                return $this->redirectToRoute('app_admin_crud_images_liste');
            }
        }

        return $this->render('admin/crud_images/ajoutImages.html.twig', [
            'formImage' => $formImage->createView(),
            'nomFormulaire' => 'modifier',
            'image' => $image->getImageChemin()
        ]);
    }

    //Supprimer une image
    #[Route('/supprimer/{id<\d+>}', name: 'supprimer_images')]
    public function supprimerImage(int $id): Response {
        $image = $this->imagesRepository->findOneBy(['id' => $id]);

        if (!$image) {
            $this->addFlash('no-success', "l'image n'existe pas !!");
            return $this->redirectToRoute('app_admin_crud_images_liste');
        }

        $this->doctrine->remove($image);
        $this->doctrine->flush();
        $this->addFlash('success', "L'image est bien supprimée");
        return $this->redirectToRoute('app_admin_crud_images_liste');
    }
}
