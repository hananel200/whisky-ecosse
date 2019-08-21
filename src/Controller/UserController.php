<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\UserType;
use App\Repository\CommandeRepository;
use App\Repository\WhiskyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/mon_compte", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig');
    }

    /**
     * @Route("/mon_compte/modif", name="modify_account")
     */
    public function modify_user(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->remove('password');
        $form->remove('confirm_password');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('success');
        }

        return $this->render('user/modify.html.twig',
            array('form' => $form->createView()));
    }

    /**
     * @Route("/mon_compte/success", name="success")
     */
    public function success()
    {
        return $this->render('user/success.html.twig');
    }


    /**
     * @Route("/mon_compte/modif_passwd", name="modify_psswd")
     */
    public function modify_psswd(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->remove('email');
        $form->remove('nom');
        $form->remove('prenom');
        $form->remove('adresse');
        $form->remove('ville');
        $form->remove('codePostal');
        $form->remove('pays');
        $form->remove('telephone');
        $form->remove('sexe');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', "Votre mot de passe a bien été modifié, veuillez vous reconnecter.");
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/modifyPsswd.html.twig',
            array('form' => $form->createView()));
    }

    /**
     * @Route("/mon_compte/delete_account", name="delete_account")
     */
    public function delete_account()
    {
        $user = $this->getUser();
        $user->setActif(false);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_logout');
    }

    /**
     * @Route("/mon_compte/commandes", name="commande")
     */
    public function commandes(CommandeRepository $commandeRepository, WhiskyRepository $whiskyRepository)
    {
        $user = $this->getUser();
        $commandes = $commandeRepository->findBy(['user' => $user->getId()]);
        foreach ($commandes as $commande) {
            $commande->setContenu(unserialize($commande->getContenu()));
            $whiskies = [];
            foreach ($commande->getContenu() as $id => $qte) {
                $whisky = $whiskyRepository->findOneBy(['id' => $id]);
                $whiskies[$whisky->getId()] = [$whisky, $qte];
            }
            $commande->setContenu($whiskies);
            $commande->setPrixTotal();
        }
        $commandes = array_reverse($commandes);
        return $this->render('user/commandes.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/mon_compte/commande/{id}", name="vue_commande")
     */
    public function vueCommande(Commande $commande, WhiskyRepository $whiskyRepository)
    {
        $commande->setContenu(unserialize($commande->getContenu()));
        $whiskies = [];
        foreach ($commande->getContenu() as $id => $qte) {
            $whisky = $whiskyRepository->findOneBy(['id' => $id]);
            $whiskies[$whisky->getId()] = [$whisky, $qte];
        }
        $commande->setContenu($whiskies);
        $commande->setPrixTotal();

        return $this->render('user/vue_commande.html.twig', [
            'commande' => $commande
        ]);
    }

}
