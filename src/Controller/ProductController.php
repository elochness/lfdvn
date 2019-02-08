<?php

/*
 * This file is part of the lfdvn package.
 *
 * (c) Pierre François
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Subcategory;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to manage user contents in the public part of the site.
 *
 * @Route({
 *     "fr": "/produits",
 *     "en": "/products"
 * })
 *
 * @author Pierre François
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="product_index")
     * @Cache(smaxage="10")
     *
     * @param Request            $request
     * @param ProductRepository  $productRepository
     * @param CategoryRepository $categoryRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $page = $request->query->get('page', 1);

        $params = [];
        if (null !== $request->query->get('category')) {
            $params['category'] = $request->query->get('category');
        }

        if (null !== $request->query->get('subcategory')) {
            $params['subcategory'] = $request->query->get('subcategory');
        }
        // $selectedCategory = $request->query->get('categorie');
        $selectedCategoryName = null;

        $products = $productRepository->findLatest($page, $params);
        $categories = $categoryRepository->findActiveCategory();

        $selectedCategoryName = $this->getCategoryName($params, $categories);
        $selectedCategoryPluralName = $this->getCategoryPluralName($selectedCategoryName);

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategoryName' => $selectedCategoryName,
            'selectedCategoryPluralName' => $selectedCategoryPluralName,
        ]);
    }

    /**
     * @Route("/show/{id}", name="product_show")
     *
     * @param $id
     * @param ProductRepository $productRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findById($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->render('product/show.html.twig', ['product' => $product]);
    }

    /**
     * @param $params
     * @param $categories
     *
     * @return string|null
     */
    private function getCategoryName($params, $categories): ?string
    {
        $selectedCategoryName = null;

        if (isset($params['category']) || isset($params['subcategory'])) {
            /* @var Category $category */
            foreach ($categories as $category) {
                if (isset($params['category'])) {
                    if ($params['category'] === $category->getId()) {
                        $selectedCategoryName = $category->getName();
                        break;
                    }
                }
                if (isset($params['subcategory'])) {
                    /* @var Subcategory $subcategory */
                    foreach ($category->getSubcategories() as $subcategory) {
                        if ($params['subcategory'] === $subcategory->getId()) {
                            $selectedCategoryName = $subcategory->getName();
                            break;
                        }
                    }
                }
            }
        }

        return $selectedCategoryName;
    }

    /**
     * Get plural name for the selected category.
     *
     * @param string $categoryName category to plural
     *
     * @return string|null category with plural
     */
    private function getCategoryPluralName($categoryName): ?string
    {
        $categoryNamePlural = null;
        if (0 === mb_strpos($categoryName, 'lait')) {
            $categoryNamePlural = 'au '.$categoryName;
        }

        return $categoryNamePlural;
    }
}
