<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\ServiceRoles;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
  private $em;

  public function __construct(EntityManagerInterface $em) {
    $this->em = $em;
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
      throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
  }
}
