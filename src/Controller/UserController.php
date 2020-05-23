<?php

namespace App\Controller;

use App\Form\Type\ChangePasswordType;
use App\Repository\ProductOrderRepository;
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
            'user' => $this->getUser(),
            'currentAction' => 'user'
        ]);
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
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var User $user */
        $user = $this->getUser();

        // 1) build the form
        $form = $this->createForm(ChangePasswordType::class);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('newPassword')->getData()));

            // 4) save the modification!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'password.updated_successfully');

            return $this->redirectToRoute('user_account');
        }

        return $this->render('user/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
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
    public function productOrderIndex(ProductOrderRepository $productOrderRepository)
    {
        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var User $user */
        $user = $this->getUser();

        // Recuperate all product order according to the buyer
        $productsOrder = $productOrderRepository->findByBuyer($user->getId());

        return $this->render('user/product_order_index.html.twig', [
            'productsOrder' => $productsOrder,
            'currentAction' => 'purchase',
        ]);
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
