<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\WhiskyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class CheckoutController extends AbstractController
{
    /**
     * @Route("/checkout", name="checkout")
     */
    public function index(Request $request)
    {
        $session = $request->getSession();

        if ($request->isMethod('POST')) {
            $order = new Commande();
            $order->setAdresse($request->request->get('adresse'));
            $order->setNomAdresse($request->request->get('nom'));
            $order->setVille($request->request->get('ville'));
            $order->setCodePostal($request->request->get('CP'));
            $session->set('commande', $order);
            return $this->redirectToRoute('paiement');
        }
        $commande = $session->get('order');
        $panier = $session->get('panier');
        $total = $panier->getTotal();
        return $this->render('checkout/index.html.twig', [
            'panier' => $panier->getListe(),
            'total' => $total,
            'commande' => $commande,
        ]);

    }

    /**
     * @Route("/paiement", name="paiement")
     */
    public function paiement(Request $request, WhiskyRepository $repow, \Swift_Mailer $mailer)
    {
        $session = $request->getSession();
        $panier = $session->get('panier');
        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();
//            $session = $request->getSession();
//            $panier = $session->get('panier');
            $order = new Commande();
            $user = $this->getUser();
            $order->setUser($user);
            $contenu = $panier->checkOutList();
            $liste = $panier->getListe();
            $content = serialize($contenu);
            $order->setContenu($content);
            foreach ($liste as $id => $item) {
                $whisky = $repow->findOneBy(['id' => $item[0]->getId()]);
                $nom_whisky = $whisky->getNom();
                if ($whisky->getUgs() < $item[1]) {
                    $this->addFlash('warning', "Le whisky $nom_whisky n'est plus disponible dans les quantités demandés! Veuillez modifiez votre panier.");
                    return $this->redirectToRoute('panier');
                }
                $whisky->setUgs($whisky->getUgs() - $item[1]);
                $entityManager->persist($whisky);
            }

            if (null != $session->get('commande')) {
                $commande = $session->get('commande');
                $order->setNomAdresse($commande->getNomAdresse());
                $order->setAdresse($commande->getAdresse());
                $order->setVille($commande->getVille());
                $order->setCodePostal($commande->getCodePostal());
            } else {
                $order->setNomAdresse($user->getNom());
                $order->setAdresse($user->getAdresse());
                $order->setVille($user->getVille());
                $order->setCodePostal($user->getCodePostal());
            }
            $entityManager->persist($order);
            $entityManager->flush();
            $total= $panier->getTotal();
            $session->set('panier', '');
            $session->set('commande', '');
            $message = (new \Swift_Message("Confirmation de votre commande N°".$order->getId()))
                ->setFrom(['dev.web.lamberger@gmail.com' => 'whisky-écosse'])
                ->setTo($user->getEmail());
                $message->setBody(
                    "<h3>Bonjour,</h3>
            Nous vous remercions de votre commande.
            Nous vous tiendrons informés par e-mail lorsque les articles de votre commande auront été expédié.<br/>
            Vous pouvez consulter le détail de votre commande sur <a href='http://localhost:8000/mon_compte'>votre espace client</a>.<br/>
            Nous espérons vous revoir bientôt.<br/>
            Très cordialement.
            ",
            'text/html'
                );

            $mailer->send($message);

            return $this->redirectToRoute('thankyou');
        }
        return $this->render('checkout/paiement.html.twig', [
            'panier' => $panier->getListe(),
            'total' => $panier->getTotal()
        ]);
    }

    /**
     * @Route("/thankyou", name="thankyou")
     */
    public function thankyou(Request $request, WhiskyRepository $repow)
    {
        return $this->render('checkout/thankyou.html.twig');
    }


}
