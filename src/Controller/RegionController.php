<?php

namespace App\Controller;

use App\Entity\Region;
use App\Repository\DistillerieRepository;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RegionController extends AbstractController
{
    /**
     * @Route("/region/{nom}", name="region")
     */
    public function index($nom, RegionRepository $repor, DistillerieRepository $repo )
    {
        $region = $repor->findOneBy(['nom' => $nom]);
        $id = $region->getId();

        $dists=$repo->findByRegion($id);
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
        return $this->render('region/index.html.twig', [
            'region' => $region,
            'dist' => $tableau,
            'distilleries' => $dists
        ]);
    }
}
