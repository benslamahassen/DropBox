<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class  UserController extends AbstractController
{
    /**
     * @Route("/signup", name="create_user", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function create(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $username = trim($request->request->get('username'));
        $email = trim($request->request->get('email'));
        $password = trim($request->request->get('password'));

        try {
            $user = new User();
            $user->setUserName($username);
            $user->setEmail($email);
            $user->setPassword($encoder->encodePassword($user, $password));

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->render('security/login.html.twig',[
                'message' => 'Account Creation Successful! Please Login'
            ]);
        } catch(\Exception $e){
            $error = $e->getMessage();
            var_dump($error);
            return $this->render('security/login.html.twig',[
                'error' => 'Account Creation Failed!'
            ]);
        }
    }
}
