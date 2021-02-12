<?php

namespace App\Controller;

use App\Security\CustomAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use App\Entity\Bet;

class BetController extends AbstractController
{
    /**
     * @Route("/listebet", name="listebet")
     */
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $username = $session->get(Security::LAST_USERNAME);

        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository(User::class);
        $betsRepository = $em->getRepository(Bet::class);

        // Récupère l'utilisateur courant
        $user = $userRepository->findOneBy(array('username' => $username));
        $idUser = $user->getId();

        // Récupère tous les paris du l'utilisateur
        $bets = $betsRepository->findBy(array('user' => $idUser), array('date' => 'DESC'));

        return $this->render('bet/index.html.twig', array('username' => $username, 'idUser' => $idUser, 'bets' => $bets));
    }
}