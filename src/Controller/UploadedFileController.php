<?php

namespace App\Controller;

use App\Entity\UploadedFile;
use App\Form\PdfFileType;
use App\Repository\UploadedFileRepository;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadedFileController extends AbstractController
{

    /**
     * @Route("/pdf", name="create_pdf")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
    {
        $pdf_file = new UploadedFile();
        $form = $this->createForm(PdfFileType::class, $pdf_file);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploaded_file = $form['file']->getData();
            $extension = $uploaded_file->getClientOriginalExtension();
            $pdf_file->setExtension($extension);
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

    /**
     * @Route("/download/{id}",name="pdf_download")
     * @param $id
     * @param UploadedFileRepository $uploadedFileRepository
     * @return Response
     */
    public function download($id, UploadedFileRepository $uploadedFileRepository)
    {
        $file = $uploadedFileRepository->findOneBy(['id' => $id]);

        $response = new Response();
        $response->headers->set('Content-type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $file->getName()));
        $response->setContent(file_get_contents($this->getParameter('kernel.project_dir') . "/public/files/" . $file->getName()));
        $response->setStatusCode(200);
        $response->headers->set('Content-Transfer-Encoding', 'binary');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        return $response;

    }

    /**
     * @Route("/rename",name="pdf_rename")
     * @param Request $request
     * @param Filesystem $filesystem
     * @param UploadedFileRepository $uploadedFileRepository
     * @return RedirectResponse
     */

    public function rename(Request $request, Filesystem $filesystem, UploadedFileRepository $uploadedFileRepository)
    {
        $id = $request->request->get('fileId');
        $fileName = $request->request->get('fileName');
        $oldFile = $uploadedFileRepository->findOneBy(['id' => $id]);
        $oldName = $oldFile->getName();
        $root_dir = $this->getParameter('kernel.project_dir');
        $absolute_path = $root_dir."/public/files/".$oldName;

        try {
            if ($filesystem->exists($absolute_path)) {
                $filesystem->rename($absolute_path, $root_dir."/public/files/".$fileName);
                $oldFile->setName($fileName);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($oldFile);
                $entityManager->flush();
                return $this->redirectToRoute("home");
            }
        } catch (IOExceptionInterface $exception) {
            return $this->redirectToRoute("home");
        }
    }

    /**
     * @Route("/delete",name="pdf_delete")
     * @param Request $request
     * @param UploadedFileRepository $uploadedFileRepository
     * @return RedirectResponse
     */

    public function delete(Request $request, UploadedFileRepository $uploadedFileRepository) {
        $id = $request->request->get('fileId');
        $file = $uploadedFileRepository->findOneBy(['id' => $id]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($file);
        $entityManager->flush();
        return $this->redirectToRoute("home");
    }
}
