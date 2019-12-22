<?php

namespace App\Controller;

use App\Service\GalleryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    /**
     * @Route("/gallery/{year}", name="gallery")
     * @param int $year
     * @return Response
     */
    public function index(int $year): Response
    {
        $galleryPics = $this->getParameter('kernel.root_dir') . '/../public/gallery/' . $year . '/';

        return $this->render('gallery/index.html.twig', [
            'controller_name' => 'GalleryController',
            'year' => $year,
            'pictures' => GalleryService::getFileList($galleryPics),
        ]);
    }
}
