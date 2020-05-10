<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route({
 *     "fr": "/produits",
 *     "en": "/products"
 * })
 *
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="product_index")
     * @Cache(smaxage="10")
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @Route("/show/{id}", name="product_show")
     *
     * @param $id
     * @param ProductRepository $productRepository
     *
     * @return Response
     */
    public function show($id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->render('product/show.html.twig', ['product' => $product]);
    }
}
