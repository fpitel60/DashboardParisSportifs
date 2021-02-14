<?php

namespace App\Controller;

use App\Entity\BetTest;
use App\Entity\GameTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GameTestController extends AbstractController
{
    /**
     * @Route("/listgametest", name="listgametest")
     */
    public function index(): Response
    {
        return $this->render('game_test/index.html.twig', [
            'controller_name' => 'GameTestController',
        ]);
    }
    
    /**
     * @Route("/gametest/bettest/show/{id}", name="showgametestbettest")
     */
    public function showBetTest(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $gameTestRepository = $em->getRepository(GameTest::class);
        $betTestRepository = $em->getRepository(BetTest::class);

        $betTest = $betTestRepository->find($id);
        $gamesTest = $gameTestRepository->findBy(array('bettest' => $betTest));

        return $this->render('game_test/show.html.twig', array(
            'gamesTest' => $gamesTest
        ));
    }

}
