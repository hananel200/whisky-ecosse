<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Whisky;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


class PanierController extends AbstractController
{

    /**
     * @Route("/panier", name="panier")
     */
    public function index(Request $request)
    {
        $session = $request->getSession();
        if (null != $session->get('panier')){
            $panier = $session->get('panier');
        }else{
            $panier = new Panier();
            $session->set('panier', $panier);
        }
        $liste= $panier->listProducts();
        if ($request->isMethod('POST'))
        {
            $error = true;
            foreach ($liste as $item)
            {
                $qte = $request->request->get($item->getId());
                if ($qte <= 0 || !is_numeric($qte)){
                    $this->addFlash('warning', "Le format pour le champs quantité n'est pas valide !");
                    $error = false;
                }
                elseif ($item->getUgs() >= $qte){
                    $panier->changeQte($item->getId(), $qte);
                }else{
                    $error = false;
                    $whisky = $item->getNom();
                    $ugs = $item->getUgs();
                    $this->addFlash('warning', "Désolé, nous n'avons plus que $ugs $whisky, veuillez modifier la quantité");
                }
            }
            if ($error==true){
                $this->addFlash('success', "Votre panier a bien été mis à jour! ");
            }
        }
        if (!$session->get('panier'))
        {
            $panier = new Panier();
            $session->set('panier', $panier);
        }
        $session->set('panier', $panier);
//           $session->remove('panier');
        return $this->render('panier/index.html.twig', [
            'panier' => $panier->getListe(),
            'liste' => $liste,
            'totalHt' => $panier->getTotalHt(),
            'total' => $panier->getTotal()
        ]);
    }


    /**
     * @Route("/ajouter/{id}", name="ajouter")
     */
    public function addProduct(Whisky $whisky, Request $request)
    {
        if ($request->isXmlHttpRequest()){
            $session = $request->getSession();
            if (!$session->get('panier'))
            {
                $panier = new Panier();
                $session->set('panier', $panier);
            }

            $panier = $session->get('panier');
            $img = $whisky->getWhiskyImgs()[0];
            if ($panier->checkProductExist($whisky)){
                $panier->addOneProduct($whisky, 1, $img);
                $session->set('panier', $panier);

                $reponse = array("msg" => "<div class=\"alert alert-success\" role=\"alert\">
                                  Votre article a bien été ajouté !
                                </div>",
                    "nb" => $panier->getNbart()." articles");
            }else{
                $reponse = array("msg" => "<div class=\"alert alert-danger\" role=\"alert\">
                              Cet article est déjà dans votre panier !
                            </div>",

                    "nb" => $panier->getNbart()." articles");
            }


            return new JsonResponse($reponse);
        }
    }


    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function removeProduct($id, Request $request)
    {
        $session = $request->getSession();
        $panier = $session->get('panier');
        $panier->removeProduct($id);
        $session->set('panier', $panier);
        return $this->redirectToRoute('panier');
    }

}
