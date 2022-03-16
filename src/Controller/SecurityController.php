<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\ServiceRoles;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
  private $em;
  private $requestStack;

  public function __construct(EntityManagerInterface $em, RequestStack $requestStack) {
    $this->em = $em;
    $this->requestStack = $requestStack;
  }

  /**
   * @Route("/register-user", name="app_register")
   */
  public function register(UserPasswordHasherInterface $passwordEncoder, ServiceRoles $roles): Response
  {
    $user = new User();

    if (isset($_POST['user_email']) && isset($_POST['user_password'])) {
      $ue = $_POST['user_email'];
      $up = $_POST['user_password'];

      $user->setEmail($ue);
      $user->setRoles(array($roles->getRole(1)));
      $user->setPassword(
        $passwordEncoder->hashPassword(
          $user,
          $up
        )
      );
      $this->em->persist($user);
    }
    $this->em->flush();

    $response = new Response();
    $response->setContent("Register user");
    $response->setStatusCode(200);
    $response->headers->set('Content-Type', 'text/html');
    return $response;
  }

  /**
   * @Route("/logout", name="app_logout")
   */
  public function logout()
  {
    $session = $this->requestStack->getSession();

    $session->clear();

    return $this->redirectToRoute('app_app');
  }

  /**
   * @Route("/session-logged-in", name="app_session_logged_in")
   */
  public function setSessionLoggedIn() {
    $session = $this->requestStack->getSession();
    if (isset($_POST['user_loged'])) {
      $session->set('userLoged', $_POST['user_loged']);
    }

    $response = new Response();
    $response->setContent("Add user in session: " . $_POST['user_loged']);
    $response->setStatusCode(200);
    $response->headers->set('Content-Type', 'text/html');
    return $response;
  }
}
