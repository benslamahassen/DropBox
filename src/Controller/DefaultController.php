<?php

namespace App\Controller;

use App\Repository\UploadedFileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function index()
    {
        return $this->render('security/login.html.twig', [
            'error' => false
        ]);
    }

    /**
     * @Route("/home", name="home")
     * @param UploadedFileRepository $uploadedFileRepository
     * @return Response
     */
    public function home(UploadedFileRepository $uploadedFileRepository)
    {
        $user_id = $this->getUser()->getId();
        $files = $uploadedFileRepository->findBy(["user_id" => $user_id]);
        return $this->render('index.html.twig', [
            'files' => $files,
        ]);
    }

}