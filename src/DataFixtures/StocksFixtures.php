<?php

namespace App\DataFixtures;

use App\Entity\Products;
use App\Entity\Stocks;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StocksFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $entrepot = $this->getReference('bout-entrepot1');
        $ldlc = $this->getReference('bout-ldlc');
        $hm = $this->getReference('bout-hm');


        $msi = $this->getReference('prod-69');
        $stock = $this->createStock($msi,$ldlc,10);
        $manager->persist($stock);
        $stock = $this->createStock($msi,$entrepot,40);
        $manager->persist($stock);

        for($prod = 1; $prod <= 10; $prod++) {
            $produit = $this->getReference('prod-'.$prod);
            $category = $produit->getCategories();
            if (in_array($category->getId(), array(2,3,4))) {
                $stock = $this->createStock($produit,$ldlc,rand(0,50));
                $manager->persist($stock);
                if (rand(0,1) == 0) {
                    $stock = $this->createStock($produit,$entrepot,rand(0,50));
                    $manager->persist($stock);
                }
            } else if (in_array($category->getId(),array(6,7,8))) {
                $stock = $this->createStock($produit,$hm,rand(0,50));
                $manager->persist($stock);
                if (rand(0,1) == 0) {
                    $stock = $this->createStock($produit,$entrepot,rand(0,50));
                    $manager->persist($stock);
                }
            } else {
                $stock = $this->createStock($produit,$entrepot,rand(0,50));
                $manager->persist($stock);
            }

        }
        $manager->flush();
    }

    public function createStock($product,$boutique,$amount) {
        $stock = new Stocks();
        $stock->setProduct($product);
        $stock->setBoutique($boutique);
        $stock->setAmount($amount);
        return $stock;
    }

    public function getDependencies(): array
    {
        return [
            BoutiquesFixtures::class,
            ProductsFixtures::class
        ];  
    }

}
