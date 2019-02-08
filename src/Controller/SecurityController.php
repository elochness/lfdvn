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

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Controller used to manage the application security.
 * See https://symfony.com/doc/current/cookbook/security/form_login_setup.html.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="security_login")
     *
     * @param AuthenticationUtils $helper
     * @param UserInterface|null  $user
     *
     * @return Response
     */
    public function login(AuthenticationUtils $helper, UserInterface $user = null): Response
    {
        // Check if user has admin role
        if (null !== $user && \in_array(User::ROLE_ADMIN, $user->getRoles(), true)) {
            return $this->redirectToRoute('easyadmin');
        }
        // Check if user has user role
        elseif (null !== $user && \in_array(User::ROLE_USER, $user->getRoles(), true)) {
            return $this->redirectToRoute('user_account');
        }

        return $this->render('security/login.html.twig', [
                // last username entered by the user (if any)
                'last_username' => $helper->getLastUsername(),
                // last authentication error (if any)
                'error' => $helper->getLastAuthenticationError(),
            ]);
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in config/packages/security.yaml
     *
     * @Route("/logout", name="security_logout")
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
}
