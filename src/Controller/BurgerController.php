<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class BurgerController extends AbstractController
{
    #[Route('/burgers', name: 'burger_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les burgers
        $burgers = $entityManager->getRepository(Burger::class)->findAll();

        return $this->render('burger/index.html.twig', [
            'burgers' => $burgers,
        ]);
    }

    #[Route('/burger/create', name: 'burger_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $burger = new Burger();
        $burger->setName('Burger Test');
        $burger->setPrice(5.99);

        $entityManager->persist($burger);
        $entityManager->flush();

        return new Response('Burger créé avec succès !');
    }

    #[Route('/burger/byIngredient', name: 'burger_by_ingredient')]
    public function burgersByIngredient(BurgerRepository $burgerRepository): Response
    {
        $burgers = $burgerRepository->findBurgersWithIngredients("Oignon");

        // Affiche dans un template
        return $this->render('burger/by_ingredient.html.twig', [
            'burgers' => $burgers,
        ]);
    }

    #[Route('/burger/top/{limit}', name: 'burger_top')]
    public function topBurgers(int $limit, BurgerRepository $burgerRepository): Response
    {
        $burgers = $burgerRepository->findTopXBurgers($limit);

        return $this->render('burger/top.html.twig', [
            'burgers' => $burgers,
            'limit' => $limit,
        ]);
    }

}