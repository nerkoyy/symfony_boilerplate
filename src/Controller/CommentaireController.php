<?php

namespace App\Controller;

use App\Entity\Commentaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CommentaireController extends AbstractController
{
    #[Route('/commentaires', name: 'commentaire_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les commentaires
        $commentaires = $entityManager->getRepository(Commentaire::class)->findAll();

        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    #[Route('/commentaire/create', name: 'commentaire_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $commentaire->setName('Commentaire Test'); // ⚠️ vérifie que ton entité Commentaire a bien une propriété "name"

        $entityManager->persist($commentaire);
        $entityManager->flush();

        return new Response('Commentaire créé avec succès !');
    }

    #[Route('/commentaire/{id}', name: 'commentaire_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $commentaire = $entityManager->getRepository(Commentaire::class)->find($id);

        if (!$commentaire) {
            return $this->render('commentaire/not_found.html.twig', [
                'id' => $id,
            ]);
        }

        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }
}
