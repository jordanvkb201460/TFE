<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Experience;

class ExperiencesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i<= 10; $i++)
        {
            $exp = new Experience();
            $exp->setIdExperience($i)
                ->setIdResearcher(10-$i)
                ->setFreeReq(true);
            if($i%2 == 0)
            {
                $exp->setCompensation(25.5);
            }
            $manager->persist($exp);
        }
        $manager->flush();
    }
}
