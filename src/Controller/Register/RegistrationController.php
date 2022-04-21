<?php

namespace App\Controller\Register;

use App\Entity\Clients;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppUserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Création de l'utilisateur avec son compte client
 */
#[Route('/inscription', name: 'app_')]
class RegistrationController extends AbstractController
{
    #[Route('', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppUserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $date = new \DateTime();
        $date->format('d/m/Y');
        $user->setDateCreation($date);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setEmail($form->get('email')->getData());
            $user->setPseudo($form->get('pseudo')->getData());


            //Relier l'utilisateur à un compte client
            if ($user->getIsClient()) {
                $client = new Clients();
                $user->setRoles(["ROLE_USER"]);
                $client->setPseudo($user->getPseudo());
                $client->setClientNom($form->get('nom')->getData());
                $client->setClientPrenom($form->get('prenom')->getData());
                $client->setDateCreation($user->getDateCreation());
                //Relier le compte client avec utilisateur
                $user->setClient($client);
                //Relier le compte utilisateur avec le client
                $client->setUtilisateur($user);
            } else {
                $user->setRoles(["ROLE_ADMIN"]);
            }


            $entityManager->persist($user);
            $entityManager->flush();

            //Message Flash
            $this->addFlash('success', 'Valider : inscription effectuée');

            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
