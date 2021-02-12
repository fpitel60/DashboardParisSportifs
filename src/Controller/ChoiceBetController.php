<?php

namespace App\Controller;

use App\Entity\Game;
use App\Service\ChoiceBet\ChoiceBetService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChoiceBetController extends AbstractController
{
    /**
     * @Route("/choicebet", name="choice_bet")
     */
    public function index(ChoiceBetService $choiceBetService): Response
    {
        $cartWithData = $choiceBetService->getFullCart();

        return $this->render('choice_bet/index.html.twig', array(
            'bets' => $cartWithData
        ));
    }

    /**
     * @Route("/choicebet/add/{id}", name="choicebet_add")
     */
    public function add($id, ChoiceBetService $choiceBetService)
    {
        $choiceBetService->add($id);

        return $this->redirectToRoute("choice_bet");
    }

    /**
     * @Route("/choicebet/remove/{id}", name="choicebet_remove")
     */
    public function remove($id, ChoiceBetService  $choiceBetService)
    {
        $choiceBetService->remove($id);

        return $this->redirectToRoute("choice_bet");
    }
}
