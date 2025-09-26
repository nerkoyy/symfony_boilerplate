<?php

namespace App\Controller;

use App\Entity\Sauce;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SauceController extends AbstractController
{
    #[Route('/sauces', name: 'sauce_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer toutes les sauces
        $sauces = $entityManager->getRepository(Sauce::class)->findAll();

        return $this->render('sauce/index.html.twig', [
            'sauces' => $sauces,
        ]);
    }

    #[Route('/sauce/create', name: 'sauce_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $sauce = new Sauce();
        $sauce->setName('Sauce Burger');

        $entityManager->persist($sauce);
        $entityManager->flush();

        return new Response('Sauce créée avec succès !');
    }
}
