<?php

namespace App\DataFixtures;

use App\Entity\Distillerie;
use App\Entity\ImageRegion;
use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use App\Entity\Whisky;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class WhiskyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');


        for ($i = 0; $i < 5; $i++) {
            $user = new ImageRegion();
            $x= rand(4,9);
            $region = $manager->getRepository(Region::class)->findOneBy(['id'=>$x]);
            $user->setTitre($faker->name);
            $user->setRegion($region);
            $user->setImageFile($faker->image('images/dist', 400, 300, null, false));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
