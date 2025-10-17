<?php

namespace App\Controller;

use App\Entity\Pain;
use App\Form\PainType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PainController extends AbstractController
{
    #[Route('/pains', name: 'painn_liste')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les pains
        $pains = $entityManager->getRepository(Pain::class)->findAll();

        return $this->render('pain/index.html.twig', [
            'pains' => $pains,
        ]);
    }

    #[Route('/pain/create', name: 'pain_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $pain = new Pain();
        $pain->setName('Pain Complet');

        $entityManager->persist($pain);
        $entityManager->flush();

        return new Response('Pain créé avec succès !');
    }

    #[Route('/pain/new', name: 'pain_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pain = new Pain();
        $form = $this->createForm(PainType::class, $pain);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pain);
            $entityManager->flush();

            return $this->redirectToRoute('painn_liste');
        }

        return $this->render('pain/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
