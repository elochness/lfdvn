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
     * @param UserInterface $user
     * @param AuthorizationCheckerInterface $authChecker
     * @return Response
     */
    public function index(UserInterface $user = null, AuthorizationCheckerInterface $authChecker): Response
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
     * @return Response
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            // 3) Encode the password (you could also do this via Doctrine li
            //stener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $em = $this->getDoctrine()->getManager();
            // $em->persist($task);
            // $em->flush();

            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/book/controller.html#flash-messages
            $this->addFlash('success', 'post.created_successfully');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/purchase", methods={"GET"}, name="user_purchase")
     * @param UserInterface $user
     * @param AuthorizationCheckerInterface $authChecker
     * @param PurchaseRepository $purchaseRepository
     * @return Response
     */
    public function purchaseIndex(UserInterface $user = null, AuthorizationCheckerInterface $authChecker, PurchaseRepository $purchaseRepository)
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
     * @param UserInterface|null $user
     * @param AuthorizationCheckerInterface $authChecker
     * @param PurchaseRepository $purchaseRepository
     * @return Response
     */
    public function purchaseShow(int $id, UserInterface $user = null, AuthorizationCheckerInterface $authChecker, PurchaseRepository $purchaseRepository)
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