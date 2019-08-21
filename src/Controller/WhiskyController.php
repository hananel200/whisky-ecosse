<?php

namespace App\Controller;

use App\Entity\Distillerie;
use App\Entity\Panier;
use App\Entity\Region;
use App\Entity\Whisky;
use App\Repository\DistillerieRepository;
use App\Repository\RegionRepository;
use App\Repository\WhiskyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class WhiskyController extends AbstractController
{
    /**
     * @Route("/whisky", name="whisky")
     */
    public function index(WhiskyRepository $repow, Request $request, RegionRepository $repor)
    {

        $form = $this->renderForm();
        $regions =$repor->findAll();
        $pagerfanta = $this->search($form, $request, $repow);
        if ($pagerfanta == null) {
            $whiskies = $repow->myFindAll();
            $adapter = new DoctrineORMAdapter($whiskies);
            $pagerfanta = new Pagerfanta($adapter);
        }
        $pagerfanta->setMaxPerPage(16);
        if (isset($_GET["page"])) {
            $pagerfanta->setCurrentPage($_GET["page"]);
        }
        return $this->render('whisky/index.html.twig', [
            'pager' => $pagerfanta,
            'form' => $form->createView(),
            'regions' => $regions
        ]);
    }

    /**
     * @Route("/whisky/{nom}", name="whisky_regions")
     */
    public function whisky_region($nom, RegionRepository $repor, WhiskyRepository $repow, DistillerieRepository $repod)
    {
        $form = $this->renderForm();
        $region = $repor->findOneBy(['nom' => $nom]);
        $whiskies = $repow->findByRegion($region->getId());
        $dist = $repod->findBy(['region' => $region->getId()]);
        $adapter = new DoctrineORMAdapter($whiskies);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(16);
        if (isset($_GET["page"])) {
            $pagerfanta->setCurrentPage($_GET["page"]);
        }
        return $this->render('whisky/indexRegion.html.twig', [
            'pager' => $pagerfanta,
            'region' => $region,
            'form' => $form->createView(),
            'distilleries' => $dist]);
    }

    /**
     * @Route("/whisky/dist/{id}", name="whisky_dist")
     */
    public function whisky_dist(Distillerie $dist,  WhiskyRepository $repow)
    {
        $form = $this->renderForm();
        $whiskies = $repow->findByDistillerie($dist->getId());
        $adapter = new DoctrineORMAdapter($whiskies);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(16);
        if (isset($_GET["page"])) {
            $pagerfanta->setCurrentPage($_GET["page"]);
        }
        return $this->render('whisky/indexDist.html.twig',
            ['pager' => $pagerfanta,
                'form' => $form->createView(),
                'distillerie' => $dist]);
    }

    /**
     * @Route("/oneWhisky/{id}", name="oneWhisky")
     */
    public function pageWhisky(Whisky $whisky, Request $request)
    {
        if ($request->isMethod('POST')) {
            $session = $request->getSession();
            if (!$session->get('panier')) {
                $panier = new Panier();
                $session->set('panier', $panier);
            }
            $panier = $session->get('panier');
            $qte = $request->request->get('qte');
            $img = $whisky->getWhiskyImgs()[0];
            $quantite= $whisky->getUgs();
            $nom=$whisky->getNom();
            if ($qte <= 0 || !is_numeric($qte)){
                $this->addFlash('warning', "Le format pour le champs quantité n'est pas valide !");
            }
            elseif ($whisky->getUgs() >= $qte && $panier->checkProductExist($whisky)) {
                $panier->addProducts($whisky, $qte, $img);
                $session->set('panier', $panier);
                $this->addFlash('success', 'Ce produit a bien été ajouté à votre panier !');
            } elseif ($panier->checkProductExist($whisky) == false) {
                $this->addFlash('warning', "Cet article est déjà dans votre panier !");
            } else {
                $this->addFlash('warning', "Désolé, nous n'avons plus que $quantite $nom, veuillez modifier la quantité");
            }

            return $this->render('whisky/oneWhisky.html.twig', [
                'whisky' => $whisky,
            ]);

        }
        return $this->render('whisky/oneWhisky.html.twig', [
            'whisky' => $whisky,
        ]);
    }


    public function renderForm()
    {
        $form = $this->createFormBuilder(null)
            ->setAction($this->generateUrl('whisky'))
            ->add('search', TextType::class, ['label' => false])
//            ->add('rechercher', SubmitType::class)
            ->getForm();

        return $form;
    }


    public function search($form, Request $request, WhiskyRepository $repow)
    {
        $form->handleRequest($request);
        $pagerfanta = null;
        if ($form->isSubmitted()) {
            $whiskies = $repow->search($form['search']->getData());
            $adapter = new DoctrineORMAdapter($whiskies);
            $pagerfanta = new Pagerfanta($adapter);
        }
        return $pagerfanta;
    }

}
