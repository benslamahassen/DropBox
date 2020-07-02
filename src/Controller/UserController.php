<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class  UserController extends AbstractController
{
    /**
     * @Route("/user/create", name="create_user", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse
     */
    public function create(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $username = trim($request->request->get('username'));
        $email = trim($request->request->get('email'));
        $password = trim($request->request->get('password'));

        $user = new User();
        $user->setUserName($username);
        $user->setEmail($email);
        $user->setPassword($encoder->encodePassword($user, $password));

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_login');
    }
}
