<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/image/new', name: 'image_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('image_liste');
        }

        return $this->render('image/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
