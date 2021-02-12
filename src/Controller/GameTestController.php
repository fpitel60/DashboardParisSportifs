<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameTestController extends AbstractController
{
    /**
     * @Route("/game/test", name="game_test")
     */
    public function index(): Response
    {
        return $this->render('game_test/index.html.twig', [
            'controller_name' => 'GameTestController',
        ]);
    }
}
