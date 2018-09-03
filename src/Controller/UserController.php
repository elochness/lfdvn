<?php
/**
 * Created by PhpStorm.
 * User: INUFRAP
 * Date: 18/07/2018
 * Time: 16:36
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use App\Repository\PurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Controller used to manage user contents in the public part of the site.
 *
 * @Route({
 *     "fr": "/compte",
 *     "en": "/account"
 * })
 *
 * @author Pierre François
 */
class UserController extends AbstractController
{

    /**
     * @Route(methods={"GET"}, name="user_account")
     * @param AuthorizationCheckerInterface $authChecker
     * @param UserInterface|null $user
     * @return Response
     */
    public function index(AuthorizationCheckerInterface $authChecker, UserInterface $user = null): Response
    {
        // Check if user is connected
        if (!$authChecker->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        return $this->render('user/index.html.twig', array(
            'user' => $user,
            'currentAction' => 'user'
        ));

    }

    /**
     * @Route({
     *     "fr": "/nouveau",
     *     "en": "/new"
     * }, methods={"GET", "POST"}, name="user_new")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/book/controller.html#flash-messages
            $this->addFlash('success', 'account.created_successfully');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView()
        ]);

    }


    /**
     * Modification of user account
     * @Route({
     *     "fr": "/modifier",
     *     "en": "/update"
     * }, methods={"GET", "POST"}, name="user_update")
     * @param Request $request
     * @param AuthorizationCheckerInterface $authChecker
     * @param UserInterface|null $user
     * @return Response
     */
    public function update(Request $request, AuthorizationCheckerInterface $authChecker, UserInterface $user = null): Response
    {
        // Check if user is connected
        if (!$authChecker->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(UserType::class, $user);
        $form->remove("username");
        $form->remove("plainPassword");

        if ($request->isMethod('POST')) {
            // false parameter can update only changed fields of user
            $form->submit($request->request->get($form->getName()), false);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'account.updated_successfully');
                return $this->redirectToRoute('user_account');
            }
        }

        return $this->render('user/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Modification of password
     * @Route({
     *     "fr": "/changer-motdepasse",
     *     "en": "/change-password"
     * }, methods={"GET", "POST"}, name="password_update")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserInterface|null $user
     * @param AuthorizationCheckerInterface $authChecker
     * @return Response
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, AuthorizationCheckerInterface $authChecker, UserInterface $user = null): Response
    {
        // Check if user is connected
        if (!$authChecker->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(UserType::class, $user);
        $form->remove("username");
        $form->remove("lastname");
        $form->remove("firstname");
        $form->remove("cellphone");

        if ($request->isMethod('POST')) {
            // false parameter can update only changed fields of user
            $form->submit($request->request->get($form->getName()), false);

            if ($form->isSubmitted() && $form->isValid()) {

                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                // 4) save the User!
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'password.updated_successfully');
                return $this->redirectToRoute('user_account');
            }
        }


        return $this->render('user/change_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Modification of user account
     * @Route({
     *     "fr": "/supprimer",
     *     "en": "/rmove"
     * }, methods={"GET", "POST"}, name="user_remove")
     * @param AuthorizationCheckerInterface $authChecker
     * @param UserInterface|null $user
     * @return Response
     */
    public function remove(AuthorizationCheckerInterface $authChecker, UserInterface $user = null): Response
    {
        // Check if user is connected
        if (!$authChecker->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $session = new Session();
        $session->invalidate();

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $session->getFlashBag()->add('success', 'account.removed_successfully');
        return $this->redirectToRoute('article_index');
    }

    /**
     * @Route("/purchase", methods={"GET"}, name="user_purchase")
     * @param AuthorizationCheckerInterface $authChecker
     * @param PurchaseRepository $purchaseRepository
     * @param UserInterface $user
     * @return Response
     */
    public function purchaseIndex(AuthorizationCheckerInterface $authChecker, PurchaseRepository $purchaseRepository, UserInterface $user = null)
    {
        // Check if user is connected
        if (!$authChecker->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        // Recuperate all purchases according to the buyer
        $purchases = $purchaseRepository->findByBuyer($user->getId());

        return $this->render('user/purchase_index.html.twig', array(
            'purchases' => $purchases,
            'currentAction' => 'purchase'
        ));

    }

    /**
     * @Route("/purchase/{id}", methods={"GET"} , name="user_purchase_show", requirements={"id"="\d+"})
     * @param int $id
     * @param AuthorizationCheckerInterface $authChecker
     * @param PurchaseRepository $purchaseRepository
     * @param UserInterface|null $user
     * @return Response
     */
    public function purchaseShow(int $id, AuthorizationCheckerInterface $authChecker, PurchaseRepository $purchaseRepository, UserInterface $user = null)
    {
        // Check if user is connected
        // Check if user is connected
        if (!$authChecker->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        // Recuperate all purchases according to the buyer
        $purchase = $purchaseRepository->findOneBy([
            'id' => $id
        ]);

        // Check the purchase and if the user is the owner of the purchase
        if ($purchase == null || $purchase->getBuyer()->getId() != $user->getId()) {

            $purchases = $purchaseRepository->findByBuyer($user->getId());

            return $this->render('user/purchase_index.html.twig', array(
                'purchases' => $purchases
            ));
        } else {

            $total = 0;

            foreach ($purchase->getItems() as $item) {
                $total += $item->getPrice();
            }

            return $this->render('user/purchase_show.html.twig', array(
                'purchase' => $purchase,
                'total' => $total,
                'currentAction' => 'purchase'
            ));
        }
    }
}