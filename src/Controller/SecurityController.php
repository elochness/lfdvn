<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class SecurityController extends AbstractController
{
    use TargetPathTrait;


    /**
     * @Route("/login", name="security_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(): void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/login", name="security_login")
     * @param Request $request
     * @param Security $security
     * @param AuthenticationUtils $helper
     * @return Response
     */
//    public function login(Request $request, Security $security, AuthenticationUtils $helper): Response
//    {
//        // if user is already logged in, don't display the login page again
//        if ($security->isGranted(User::ROLE_ADMIN)) {
//            return $this->redirectToRoute('easyadmin');
//        }
//        else if ($security->isGranted(User::ROLE_USER)) {
//            return $this->redirectToRoute('user_account');
//        }
//
//        // this statement solves an edge-case: if you change the locale in the login
//        // page, after a successful login you are redirected to a page in the previous
//        // locale. This code regenerates the referrer URL whenever the login page is
//        // browsed, to ensure that its locale is always the current one.
//        $this->saveTargetPath($request->getSession(), 'main', $this->generateUrl('user_account'));
//
//        return $this->render('security/login.html.twig', [
//            // last username entered by the user (if any)
//            'last_username' => $helper->getLastUsername(),
//            // last authentication error (if any)
//            'error' => $helper->getLastAuthenticationError(),
//        ]);
//    }

    /**
     * @Route({
     *     "fr": "/nouveau_utilisateur",
     *     "en": "/new_user"
     * },  methods="GET|POST", name="security_user_new")
     *
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @param UserRepository $userRepository
     * @return Response
     */
    public function new(Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): Response
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $errorMessage = null;

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordHasher->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            try {
                $userRepository->save($user);

                // Flash messages are used to notify the user about the result of the
                // actions. They are deleted automatically from the session as soon
                // as they are accessed.
                // See https://symfony.com/doc/current/book/controller.html#flash-messages
                $this->addFlash('success', 'account.created_successfully');

                return $this->redirectToRoute('homepage');

            } catch (OptimisticLockException $e) {
                $errorMessage = $e->getMessage();
            } catch (ORMException $e) {
                $errorMessage = $e->getMessage();
            }

        }
        return $this->render('security/user_new.html.twig', [
            'form' => $form->createView(),
            'errorMessage' => $errorMessage
        ]);
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in config/packages/security.yaml
     *
     * @Route("/logout", name="security_logout")
     * @throws \Exception
     */
//    public function logout(): void
//    {
//        throw new \Exception('This should never be reached!');
//    }
}