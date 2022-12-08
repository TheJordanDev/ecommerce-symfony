<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatistiquesController extends AbstractController
{
    #[Route('/statistiques', name: 'app_statistiques')]
    public function index(CategoriesRepository $categoriesRepository, ProductsRepository $productsRepository): Response
    {
        return $this->render('statistiques/index.html.twig', [
            'categories' => $categoriesRepository->findBy([], ['name'=>'asc']),
            'produits' => $productsRepository->findByPriceUnder(50),
            'presetProduits' => $productsRepository->getProduitsOfCategory("Ecrans")
        ]);
    }
}
