<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BurgerController extends AbstractController
{
    #[Route('/burgers', name: 'burgers')]
    public function list(): Response
    {
        return $this->render('burger_list.html.twig');
    }

    #[Route('burger/{id}', name:"burger_show")]
    public function show($id): Response
    {
        $burgers = [
            1 => ['name' => 'Cheeseburger', 'price' => 5.99, 'description' => 'Burger au fromage'],
            2 => ['name' => 'Chickenburger', 'price' => 9.99, 'description' => 'Burger au poulet'],
            3 => ['name' => 'Baconburger', 'price' => 10.99, 'description' => 'Burger au bacon'],
        ];

        if(!isset($burgers[$id])) {
            return $this->render('burger_not_found.html.twig');
        }

        $burger = $burgers[$id];

        return $this->render('burger_show.html.twig', ['id'=>$id, 'burger'=>$burger]);
    }
}