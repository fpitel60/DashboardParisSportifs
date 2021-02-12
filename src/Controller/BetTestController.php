<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\BetTest;
use App\Form\BetTestType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BetTestController extends AbstractController
{
    /**
     * @Route("/listebettest", name="listebettest")
     */
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $username = $session->get(Security::LAST_USERNAME);

        $em = $this->getDoctrine()->getManager();
        $betTestRepository = $em->getRepository(BetTest::class);
        $userRepository = $em->getRepository(User::class);

        // Récupère l'utilisateur courant
        $user = $userRepository->findOneBy(array('username' => $username));

        return $this->render('bet_test/index.html.twig', array(
            'bets' => $betTestRepository->findBy(array('user' => $user->getId()))
        ));
    }

    /**
     * @Route("/bettest/create", name="createbettest")
     */
    public function create(Request $request) 
    {
        $session = $request->getSession();
        $username = $session->get(Security::LAST_USERNAME);

        $betTest = new BetTest;

        $formBetTest = $this->createForm(BetTestType::class, $betTest);

        $formBetTest->add('creer', SubmitType::class, array('label' => 'Valider'));

        $formBetTest->handleRequest($request);

        if($request->isMethod('post') && $formBetTest->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $userRepository = $em->getRepository(User::class);

            $user = $userRepository->findOneBy(array('username' => $username));
            $betTest->setUser($user);

            $games = $betTest->getGamesTest();
            $cote = 1;
            foreach($games as $game) {
                $cote *= $game->getCote();
                $game->setBetTest($betTest);
            }
            $betTest->setCote($cote);
            
            $em->persist($betTest);
            $em->flush();

            return $this->redirect($this->generateUrl('listebettest'));
        }
        return $this->render('bet_test/create.html.twig', array('my_form' => $formBetTest->createView()));
    }

    /**
     * @Route("/updatebettest/{id}", name="updatebettest")
     */
    public function update(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $betTestRepository = $em->getRepository(BetTest::class);
        $betTest = $betTestRepository->find($id);

        $formBetTest = $this->createForm(BetTestType::class, $betTest);

        $formBetTest->add('creer', SubmitType::class, array('label' => 'Mise à jour du paris'));

        $formBetTest->handleRequest($request);

        if($request->isMethod('post') && $formBetTest->isValid()) {
            if($betTest->getResultBet() == null) {
                $betTest->setGain(null);
            }
            elseif($betTest->getResultBet() == "Valide") {
                $betTest->setGain($betTest->getCote()*$betTest->getMise());
            }
            else {
                $betTest->setGain(0);
            }

            $em->persist($betTest);
            $em->flush();

            $this->addFlash('message', 'Paris mis à jour');
            
            return $this->redirect($this->generateUrl('listebettest'));
        }

        return $this->render('bet_test/create.html.twig', array('my_form' => $formBetTest->createView()));
    }
}