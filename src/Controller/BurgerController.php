<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Form\BurgerType;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $burger = new Burger();

        $form = $this->createForm(BurgerType::class, $burger);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($burger);
            $em->flush();

            $this->addFlash('success', 'Burger créé !');

            return $this->redirectToRoute('burger_index');
        }

        return $this->render('burger/new.html.twig', [
            'form' => $form,
        ]);
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

    #[Route('/burger/without/{ingredientName}', name: 'burger_without_ingredient')]
    public function burgersWithoutIngredient(string $ingredientName, BurgerRepository $burgerRepository): Response
    {
        $burgers = $burgerRepository->findBurgersWithoutIngredient($ingredientName);

        return $this->render('burger/without.html.twig', [
            'burgers' => $burgers,
            'ingredientName' => $ingredientName,
        ]);
    }

    #[Route('/burger/minIngredients/{min}', name: 'burger_min_ingredients')]
    public function burgersWithMinimumIngredients(int $min, BurgerRepository $burgerRepository): Response
    {
        $burgers = $burgerRepository->findBurgersWithMinimumIngredients($min);

        return $this->render('burger/min_ingredients.html.twig', [
            'burgers' => $burgers,
            'minIngredients' => $min,
        ]);
    }

}