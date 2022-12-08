<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class ProductsFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        // use the factory to create a Faker\Generator instance
        $faker = Faker\Factory::create('fr_FR');

        $ecran = new Products();
        $ecran->setName("MSI 29.5\" LED - Optix MAG301CR2");
        $ecran->setDescription("2560 x 1080 pixels - 1 ms (MPRT) - 21/9 - Dalle VA incurvée - 200 Hz - RGB - FreeSync - HDMI/DisplayPort/USB-C");
        $ecran->setSlug($this->slugger->slug($ecran->getName())->lower());
        $ecran->setPrice(37900);
        $ecran->setStock(10);
        $ecran->setWeight(7);
        //On va chercher une référence de catégorie
        $category = $this->getReference('cat-3');
        $ecran->setCategories($category);
        $this->setReference('prod-69', $ecran);
        $manager->persist($ecran);

        for($prod = 1; $prod <= 10; $prod++){
            $product = new Products();
            $product->setName($faker->text(15));
            $product->setDescription($faker->text());
            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $product->setPrice($faker->numberBetween(900, 150000));
            $product->setStock($faker->numberBetween(0, 10));
            $product->setWeight($faker->numberBetween(1, 10));

            //On va chercher une référence de catégorie
            $category = $this->getReference('cat-'. rand(1, 8));
            $product->setCategories($category);

            $this->setReference('prod-'.$prod, $product);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
