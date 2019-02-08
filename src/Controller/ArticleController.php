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

use App\Repository\ArticleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route(methods={"GET"}, name="article_index")
     * @Route("/page/{page<[1-9]\d*>}",  methods={"GET"}, name="article_index_paginated")
     * @Cache(smaxage="10")
     *
     * @param Request           $request
     * @param ArticleRepository $articleRepository
     *
     * @return Response
     */
    public function index(Request $request, ArticleRepository $articleRepository): Response
    {
        $page = $request->query->get('page', 1);
        $articles = $articleRepository->findLatest($page);

        return $this->render('article/index.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route({
     *     "fr": "/entreprise",
     *     "en": "/enterprise"
     * }, methods={"GET"}, name="article_enterprise")
     * @Cache(smaxage="10")
     *
     * @param ArticleRepository $articleRepository
     *
     * @return Response
     */
    public function enterpriseShow(ArticleRepository $articleRepository): Response
    {
        $articlesEnterprise = $articleRepository->findEnterprise();

        return $this->render('article/enterprise.html.twig', ['articles' => $articlesEnterprise]);
    }

    /**
     * @Route({
     *     "fr": "/recettes",
     *     "en": "/recipes"
     * }
     * , methods={"GET"}, name="article_recipe")
     * @Cache(smaxage="10")
     *
     * @param ArticleRepository $articleRepository
     *
     * @return Response
     */
    public function recipeShow(ArticleRepository $articleRepository): Response
    {
        $articlesRecipe = $articleRepository->findRecipe();

        return $this->render('article/recipe.html.twig', ['articles' => $articlesRecipe]);
    }

    /**
     * @param ArticleRepository $articleRepository
     *
     * @return Response
     */
    public function bandeauShow(ArticleRepository $articleRepository): Response
    {
        $articlesBandeau = $articleRepository->findBandeau();

        return $this->render('article/bandeau.html.twig', ['articlesBandeau' => $articlesBandeau]);
    }
}
