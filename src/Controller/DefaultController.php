<?php

namespace App\Controller;

use App\Repository\PdfFileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function index()
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/home", name="home")
     * @param PdfFileRepository $pdfFileRepository
     * @return Response
     */
    public function home(PdfFileRepository $pdfFileRepository)
    {
        $user_id = $this->getUser()->getId();
        $files = $pdfFileRepository->findBy(["user_id" => $user_id]);
        return $this->render('index.html.twig', [
            'files' => $files,
        ]);
    }

}