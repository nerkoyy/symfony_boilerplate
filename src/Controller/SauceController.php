<?php

namespace App\Controller;

use App\Entity\Sauce;
use App\Form\SauceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SauceController extends AbstractController
{
    #[Route('/sauces', name: 'sauce_liste')]
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

    #[Route('/sauce/new', name: 'sauce_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sauce = new Sauce();
        $form = $this->createForm(SauceType::class, $sauce);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sauce);
            $entityManager->flush();

            return $this->redirectToRoute('sauce_liste');
        }

        return $this->render('sauce/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
