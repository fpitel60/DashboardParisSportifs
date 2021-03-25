<?php

namespace App\Service\BetTest;

use App\Entity\BetTest;
use App\Repository\UserRepository;
use App\Repository\BetTestRepository;
use App\Repository\BankrollRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BetTestService {

    protected $session;
    protected $betTestRepository;
    protected $bankrollRepository;
    protected $userRepository;
    protected $em;

    public function __construct(SessionInterface $session, UserRepository $userRepository, BetTestRepository $betTestRepository, BankrollRepository $bankrollRepository, EntityManagerInterface $em) {
        $this->session = $session;
        $this->betTestRepository = $betTestRepository;
        $this->bankrollRepository = $bankrollRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    // Récupère l'utilisateur courant
    public function getCurrentUser() {
        $username = $this->session->get(Security::LAST_USERNAME);
        $user = $this->userRepository->findOneBy(array('username' => $username));

        return $user;
    }

    // Récupère la bankroll courrante
    public function getDefaultBankroll() {
        $defaultBankrollId = $this->session->get('defaultBankrollId');
        $defaultBankroll = $this->bankrollRepository->find($defaultBankrollId);

        return $defaultBankroll;
    }

    // Récupère la bankroll courrante
    public function getCurrentBankroll() {
        $currentBankrollId = $this->session->get('currentBankrollId');
        $currentBankroll = $this->bankrollRepository->find($currentBankrollId);

        return $currentBankroll;
    }

    // Récupère les paris de l'utilisateur courant
    public function getBetsTestOrderByDate() {
        $bankroll = $this->getCurrentBankroll();
        $betsTest = $this->betTestRepository->findBy(array(
            'bankroll' => $bankroll->getId()
        ),
        array('date' => 'DESC')
    );

        return $betsTest;
    }

    // Récupère les paris gagnant ou perdant de l'utilisateur courant
    public function getBetsTestByResult() {
        $bankroll = $this->getCurrentBankroll();
        $betsTest = $this->betTestRepository->findByResultBet($bankroll);

        return $betsTest;
    }

    // Récupère les paris gagné
    public function getBetsTestWin() {
        $bankroll = $this->getCurrentBankroll();

        $betsTest = $this->betTestRepository->findBy(array('resultBet' => 'Valide', 'bankroll' => $bankroll->getId()));

        return $betsTest;
    }

    // Récupère les paris perdu
    public function getBetsTestLoose() {
        $bankroll = $this->getCurrentBankroll();

        $betsTest = $this->betTestRepository->findBy(array('resultBet' => 'Perdu', 'bankroll' => $bankroll->getId()));

        return $betsTest;
    }

    // Calcul le ROI de l'utilisateur courant
    public function calculRoi() {
        $bankroll = $this->getCurrentBankroll();
        $betsTest = $this->getBetsTestByResult();

        $gainsCumul = 0;
        $misesCumul = 0;

        foreach($betsTest as $bettest) {
            if($bettest->getResultBet() == 'Valide') {
                $gainsCumul += ($bettest->getGain());  
            }
            $misesCumul += $bettest->getMise();
        }
        $bankroll->setMisesCumul($misesCumul);
        $benefsCumul = $gainsCumul - $misesCumul;
        $bankroll->setBenefsCumul($benefsCumul);
        if($misesCumul != 0 && $bettest->getBankroll()->getCurrentBankroll() != 0) {
            // ROI = (Bénéfices cumulés/Mises cumulées)*100
            $bankroll->setRoi(($benefsCumul/$misesCumul)*100);
        }

        $this->em->persist($bankroll);
        $this->em->flush();
    }

    // Calcul le ROC de l'utilisateur courant
    public function calculRoc() {
        $bankroll = $this->getCurrentBankroll();
        $betsTest = $this->getBetsTestByResult();

        $gainsCumul = 0;
        $misesCumul = 0;

        foreach($betsTest as $bettest) {
            if($bettest->getResultBet() == 'Valide') {
                $gainsCumul += ($bettest->getGain());  
            }
            $misesCumul += $bettest->getMise();
        }
        $bankroll->setMisesCumul($misesCumul);
        $benefsCumul = $gainsCumul - $misesCumul;
        $bankroll->setBenefsCumul($benefsCumul);
        if($misesCumul != 0 && $bettest->getBankroll()->getCurrentBankroll() != 0) {
            // ROC = (Bénéfices cumulés/Bankroll de départ)*100
            $bankroll->setRoc(($benefsCumul/$bankroll->getStartBankroll())*100);
        }

        $this->em->persist($bankroll);
        $this->em->flush();
    }

    // Calcul la côte du paris en fonction de chaque côte du match du paris
    public function calculCoteBet(BetTest $betTest) {
        // Calcul la cote du bet à partir de chaque match
        $games = $betTest->getGamesTest();
        $cote = 1;
        foreach($games as $game) {
            $cote *= $game->getCote();
            $game->setBetTest($betTest);
        }
        $betTest->setCote($cote);

        $this->em->persist($betTest);
        $this->em->flush();
    }

    // Calcul le gain du paris
    public function calculGain(BetTest $betTest) {
        if($betTest->getResultBet() == null) {
            $betTest->setGain(null);
        }
        elseif($betTest->getResultBet() == "Valide") {
            $betTest->setGain($betTest->getCote()*$betTest->getMise());
        }
        else {
            $betTest->setGain(0);
        }

        $this->em->persist($betTest);
        $this->em->flush();
    }

    // Calcul de la bankroll
    public function calculBankroll() {
        $bankroll = $this->getCurrentBankroll();
        $betsTest = $this->betTestRepository->findBy(array('bankroll' => $bankroll->getId()));

        $startBankroll = $bankroll->getStartBankroll();
        foreach($betsTest as $betTest) {
            if($betTest->getResultBet() != null) {
                $startBankroll -= $betTest->getMise();
                $startBankroll += $betTest->getGain();
            }
            else {
                $startBankroll -= $betTest->getMise();
            }
        }

        $bankroll->setCurrentBankroll($startBankroll);

        $this->em->persist($bankroll);
        $this->em->flush();
    }

    public function countBetsTestByDate() {
        $bankroll = $this->getCurrentBankroll();

        return $this->betTestRepository->countByDate($bankroll);
    }

    public function countBetsTestByDateByResult(string $resultBet) {
        $bankroll = $this->getCurrentBankroll();

        return $this->betTestRepository->countByDateByResult($bankroll, $resultBet);
    }

    public function getBetsTestByDateByResult($date) {
        $bankroll = $this->getCurrentBankroll();

        return $this->betTestRepository->findBetsTestByDateByResult($bankroll, $date);
    }
}

