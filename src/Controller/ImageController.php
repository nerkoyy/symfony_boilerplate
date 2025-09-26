<?php

namespace App\Controller;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ImageController extends AbstractController
{
    #[Route('/images', name: 'image_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer toutes les images
        $images = $entityManager->getRepository(Image::class)->findAll();

        return $this->render('image/index.html.twig', [
            'images' => $images,
        ]);
    }

    #[Route('/image/create', name: 'image_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $image = new Image();
        $image->setName('Image Test');

        $entityManager->persist($image);
        $entityManager->flush();

        return new Response('Image créée avec succès !');
    }
}
