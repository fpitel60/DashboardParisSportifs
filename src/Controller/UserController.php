<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Bankroll;
use App\Service\BetTest\BetTestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {}

    /**
     * @Route("/user/stats", name="userstats")
     */
    public function stats(BetTestService $betTestService): Response
    {
        // Calcul du nombre total de Win/Loose
        $betsTestWin = $betTestService->getBetsTestWin();
        $betTestLoose = $betTestService->getBetsTestLoose();

        $betsTestResultCount = [];
        $betsTestResultCount[] = count($betsTestWin);
        $betsTestResultCount[] = count($betTestLoose);

        // Calcul de Win/Loose par Date
        $countWin = [];
        $countLoose = [];
        $dates = [];

        $betsTestByDateByResult = $betTestService->countBetsTestByDateByResult("Valide");
        foreach($betsTestByDateByResult as $bet) {
            $countWin[] = $bet["count"];
        }

        $betsTestByDateByResult = $betTestService->countBetsTestByDateByResult("Perdu");
        foreach($betsTestByDateByResult as $bet) {
            $countLoose[] = $bet["count"];
        }

        $betsTestByDate = $betTestService->countBetsTestByDate();
        foreach($betsTestByDate as $bet) {
            $dates[] = $bet["dateBets"];
        }

        // Calcul du Bénéfice/Perte par date
        $benefPerte = [];
        $countBetsTestByDate = $betTestService->countBetsTestByDate();
        foreach($countBetsTestByDate as $date) {
            $betsByDateByResult = $betTestService->getBetsTestByDateByResult($date['dateBets']);
            $beneficePerte = 0;
            foreach($betsByDateByResult as $bet) {
                if($bet->getResultBet() == 'Valide') {
                    $beneficePerte += ($bet->getGain() - $bet->getMise());
                }
                elseif($bet->getResultBet() == 'Perdu') {
                    $beneficePerte -= $bet->getMise();
                }
            }
            $benefPerte[] = $beneficePerte;
        }

        // Calcul de la bankroll par date
        $bankrollByDate = [];
        $currentBankroll = $betTestService->getCurrentBankroll();
        $bankroll = $currentBankroll->getStartBankroll();
        $countBetsTestByDate = $betTestService->countBetsTestByDate();
        foreach($countBetsTestByDate as $date) {
            $betsByDateByResult = $betTestService->getBetsTestByDateByResult($date['dateBets']);
            $betBenefPerte = 0;
            foreach($betsByDateByResult as $bet) {
                $betBenefPerte += ($bet->getGain() - $bet->getMise());
                $bankroll += $betBenefPerte;
            }
            $bankrollByDate[] = $bankroll;
        }

        return $this->render('user/stats.html.twig', array(
            'betsTestResultCount' => json_encode($betsTestResultCount),
            'countWin' => json_encode($countWin),
            'countLoose' => json_encode($countLoose),
            'dates' => json_encode($dates),
            'benefPerte' => json_encode($benefPerte),
            'bankrollByDate' => json_encode($bankrollByDate)
        ));
    }
}
