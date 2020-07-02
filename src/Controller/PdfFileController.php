<?php

namespace App\Controller;

use App\Entity\PdfFile;
use App\Form\PdfFileType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfFileController extends AbstractController
{

    /**
     * @Route("/pdf", name="create_pdf")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
    {
        $pdf_file = new PdfFile();
        $form = $this->createForm(PdfFileType::class, $pdf_file);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $uploaded_file = $form['file']->getData();
            $pdf_file->setExtension($uploaded_file->getClientOriginalExtension());
            $pdf_file->setUserId($this->getUser());
            $pdf_file->setFile($uploaded_file);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pdf_file);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('pdf_file/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
