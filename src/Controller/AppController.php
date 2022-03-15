<?php

namespace App\Controller;

use App\Entity\Film;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Route("/", name="app_app")
     */
    public function index(): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    /**
     * @Route("/post-film-id", options={"expose"=true}, name="add_poster_to_film")
     */
    public function addPoster(FileUploader $fileUploader)
    {
        $movieAll = $this->em->getRepository(Film::class)->findAll();
        $movie = $this->em->getRepository(Film::class)->findOneBy(['id' => $movieAll[sizeof($movieAll)-1]->getId()]);
        $res = "";
        $sc = 0;

        if (isset($_FILES['image'])) {
            $img = $_FILES['image'];
            $file = new UploadedFile($img['tmp_name'], $img['name'], $img['type']);
            if(!is_null($file)){
                $fileName = $fileUploader->upload($file, 'dossier_img');

                if (is_string($fileName)) {
                    $movie->setPoster($fileName);
                    $this->em->persist($movie);
                    $res = "Adding poster into movie row";
                    $sc = 200;
                }else{
                    $fileUploader->errMessage();
                    $this->em->remove($movie);
                    $res = "Delete file and row in db";
                    $sc = 400;
                }
            }
        }

        $this->em->flush();

        $response = new Response();
        $response->setContent($res);
        $response->setStatusCode($sc);
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }

}