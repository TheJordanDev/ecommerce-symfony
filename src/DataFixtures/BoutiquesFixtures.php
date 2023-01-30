<?php

namespace App\DataFixtures;

use App\Entity\Boutiques;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BoutiquesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $entrepot1 = new Boutiques();
        $entrepot1->setName("Entrepôt 1");
        $entrepot1->setDematerialised(true);
        $this->setReference('bout-entrepot1', $entrepot1);
        $manager->persist($entrepot1);

        $boutique = new Boutiques();
        $boutique->setName("LDLC - Saint-Priest-en-Jarez");
        $this->setReference('bout-ldlc', $boutique);
        $manager->persist($boutique);

        $boutique = new Boutiques();
        $boutique->setName("H&M - Steel Saint-Etienne");
        $this->setReference('bout-hm', $boutique);
        $manager->persist($boutique);

        $manager->flush();
    }

}