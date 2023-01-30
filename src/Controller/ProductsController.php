<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\BoutiquesRepository;
use App\Repository\StocksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produits', name: 'products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('products/index.html.twig');
    }

    #[Route('/{slug}', name: 'details')]
    public function details(Products $product, StocksRepository $stocks, BoutiquesRepository $boutiques): Response
    {
        $productBoutiques = $stocks->getBoutiquesOfProduct($product);
        $boutiquesArray = array("web"=>0,"boutiques"=>0);
        foreach ($productBoutiques as $stock) {
            $boutique = $boutiques->findOneBy(["id"=>$stock->getBoutique()]);
            if ($boutique->isDematerialised()) {
                $boutiquesArray["web"] = $boutiquesArray["web"]+1; 
            } else {
                $boutiquesArray["boutiques"] = $boutiquesArray["boutiques"]+1; 
            }
        }
        return $this->render('products/details.html.twig', [
            'product' => $product,
            'stock' => $boutiquesArray
        ]);
    }
}