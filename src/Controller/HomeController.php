<?php

namespace App\Controller;

use App\Entity\Distillerie;
use App\Entity\ImageDist;
use App\Form\DistillerieType;
use App\Form\ImageDistType;
use App\Repository\DistillerieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     * @Route("/home", name="home")
     */
    public function index(DistillerieRepository $repo)
    {
        $dists=$repo->findAll();
        $tab=[];
        foreach ($dists as $dist) {
            if (null !== ($dist->getImageDists()[0]))
            {
                $img_dist = $dist->getImageDists()[0]->getFilename();
            }else{
                $img_dist = "";
            }
            if(null !== $dist->getDescription1()){
                $desc = substr($dist->getDescription1(),0,100)."...";
            }else{
                $desc = "";
            }
            $distillerie=["nom"=>$dist->getNom(),
                          "latitude"=>$dist->getLatitude(),
                          "longitude"=>$dist->getLongitude(),
                          "img"=>$img_dist,
                          "desc"=>$desc,
                          "id" => $dist->getId()
                           ];
            $tab[]=$distillerie;
        }
       $tableau=json_encode($tab);

       return $this->render('home/index.html.twig',array('dist'=>$tableau));
    }

//    /**
//     * @Route("/new", name="new")
//     */
//    public function newDist(Request $request)
//    {
//        $dist = new Distillerie();
//        $form = $this->createForm(DistillerieType::class, $dist);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $dist = $form->getData();
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($dist);
//            $entityManager->flush();
//            return $this->redirectToRoute('new_photos', ['id' => $dist->getId()]);
//        }
//
//        return $this->render('home/newdist.html.twig',
//            array('form'=>$form->createView()));
//    }

//    /**
//     * @Route("/new/image", name="new_photo")
//     * @Route("/new/image/{id}", name="new_photos")
//     */
//    public function addImages(Request $request, Distillerie $dist = null)
//    {
//        $entityManager = $this->getDoctrine()->getManager();
//        $image=new ImageDist();
//        $form = $this->createForm(ImageDistType::class, $image);
//        if($dist == null){
//            $form->add ('distillerie', EntityType::class,[
//                'class' => Distillerie::class,
//                'choice_label' => 'nom',
//            ]);
//        };
//        $form->add('save', SubmitType::class);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $image->setTitre($form['titre']->getData());
//            if ($dist != null){
//                $image->setDistillerie($dist);
//            }else{
//                $image->setDistillerie($form['distillerie']->getData());
//            };
//            $entityManager->persist($image);
//            $entityManager->flush();
//            if ($dist == null){
//                $dist = $form['distillerie']->getData();
//            }
//            return $this->redirectToRoute('new_photos', ['id' => $dist->getId()]);
//        }
//        return $this->render('home/newdistImg.html.twig',
//            array('form'=>$form->createView()));
//    }
}
