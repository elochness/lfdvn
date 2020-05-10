<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route({
 *     "fr": "/compte",
 *     "en": "/account"
 * })
 * @IsGranted(User::ROLE_USER)
 */
class UserController extends AbstractController
{

    /**
     * @Route(methods={"GET"}, name="user_account")
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route({
     *     "fr": "/nouveau",
     *     "en": "/new"
     * },  methods="GET|POST", name="user_new")
     *
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) : Response
    {
        // TODO create user function
        return new Response();
    }

    /**
     * @Route({
     *     "fr": "/modifier",
     *     "en": "/edit"
     * },  methods="GET|POST", name="user_edit")
     *
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request) : Response
    {
        // TODO edit user function
        return new Response();
    }

    /**
     * @Route({
     *     "fr": "/supprimer",
     *     "en": "/remove"
     * },  methods="GET|POST", name="user_remove")
     *
     * @param Request $request
     * @return Response
     */
    public function remove(Request $request) : Response
    {
        // TODO remove user function
        return new Response();
    }

    /**
     * @Route({
     *     "fr": "/changer-mot-de-passe",
     *     "en": "/change-password"
     * }, methods="GET|POST", name="password_update")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        // TODO change password user function
        return new Response();
    }

    /**
     * @Route({
     *     "fr": "/commande-de-produits",
     *     "en": "/product-order"
     * }, methods="GET", name="user_product_order_index")
     *
     *
     * @return Response
     */
    public function productOrderIndex()
    {
        // TODO product order user function
        return new Response();
    }

    /**
     * @Route({
     *     "fr": "/commande-de-produits/{id}",
     *     "en": "/product-order/{id}"
     * }, methods="GET", name="user_product_order_show", requirements={"id"="\d+"})
     *
     * @return Response
     */
    public function productOrderShow()
    {
        // TODO show product order user function
        return new Response();
    }
}
