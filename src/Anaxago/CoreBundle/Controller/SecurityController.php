<?php

namespace Anaxago\CoreBundle\Controller;

use Anaxago\CoreBundle\Entity\User;
use Anaxago\CoreBundle\Form\Type\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 *
 * @package Anaxago\CoreBundle\Controller
 */
class SecurityController extends Controller
{
    /**
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function loginAction(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            '@AnaxagoCore/login.html.twig',
            array(
                'last_username' => $lastUsername,
                'error' => $error,
            )
        );
    }

    /**
     * @param Request                $request
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface  $tokenStorage
     * @param Session                $session
     *
     * @return Response
     */
    public function registrationAction(Request $request, EntityManagerInterface $em, TokenStorageInterface $tokenStorage, Session $session): Response
    {
        $newUser = new User();
        $registrationForm = $this->createForm(RegistrationType::class, $newUser);
        $registrationForm->add('S\'enregistrer', SubmitType::class);

        $registrationForm->handleRequest($request);
        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $em->persist($newUser);
            $em->flush();

            // login user after its registration
            $usernameToken = new UsernamePasswordToken($newUser, $newUser->getPassword(), 'main', $newUser->getRoles());
            $tokenStorage->setToken($usernameToken);
            $session->set('_security_main', serialize($usernameToken));

            return $this->redirectToRoute('anaxago_core_homepage');
        }

        return $this->render('@AnaxagoCore/registration.html.twig', ['form' => $registrationForm->createView()]);
    }
}
