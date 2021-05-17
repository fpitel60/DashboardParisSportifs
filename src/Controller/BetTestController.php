<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\BetTest;
use App\Form\BetTestType;
use App\Entity\PalierMontante;
use App\Service\BetTest\BetTestService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BetTestController extends AbstractController
{

    // Return number of the week
    function weekOfYear($date) {
        $weekOfYear = intval(date("W", $date));
        if (date('n', $date) == "1" && $weekOfYear > 51) {
            // It's the last week of the previos year.
            $weekOfYear = 0;    
        }
        return $weekOfYear;
    }

    /**
     * @Route("/listebettest", name="listebettest")
     */
    public function index(Request $request, BetTestService $betTestService, PaginatorInterface $paginator): Response
    {
        $currentBankroll = $betTestService->getCurrentBankroll();

        $betTestService->calculRoi();
        $betTestService->calculRoc();
        $betTestService->calculBankroll();

        //$test = $betTestService->getWeeks();

        $tests2 = $betTestService->getMonths();
        $array = array(
        );

        foreach($tests2 as $test2) {
            if(intval($test2['gbMonth']) <10) {
                $month = '0'.$test2['gbMonth'];
            }
            else {
                $month = $test2['gbYear'];
            }
            $year = $test2['gbYear'];

            $array[] = array(
                'gbMonth' => $month,
                'gbYear' => $year,
                'bets' => $betTestService->getBetsTestByMonth(intval($month), intval($year))
            );
        }

        $betsTest = $paginator->paginate(
            $betTestService->getBetsTestOrderByDate(), // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10, // Nombre de résultats par page
            array(
                'defaultSortFieldName' => 'bt.date',
                'defaultSortDirection' => 'desc',
            )
        );

        $betsTest->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination)
            'size' => 'small', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);

        return $this->render('bet_test/index.html.twig', array(
            'bets' => $betsTest,
            'currentBankroll' => $currentBankroll,
            'tests' => $array,
        ));
    }

    /**
     * @Route("/bettest/create/{montanteid}/{numberpalier}", defaults={"montanteid" = null, "numberpalier" = null}, name="createbettest")
     */
    public function create(Request $request, $montanteid, $numberpalier, BetTestService $betTestService) 
    {
        $bankroll = $betTestService->getCurrentBankroll();

        $betTest = new BetTest;

        $formBetTest = $this->createForm(BetTestType::class, $betTest);
        $formBetTest->add('creer', SubmitType::class, array('label' => 'Valider'));

        $formBetTest->handleRequest($request);

        if($request->isMethod('post') && $formBetTest->isValid()) {
            $betTest->setBankroll($bankroll);

            // Get Bet's Date
            $date = $betTest->getDate()->format('Y-m-d');
            // Get number of the week
            $week = $this->weekOfYear(strtotime($date));
            $betTest->setWeek($week);

            // Set the bet's date
            $duedt = explode("-", $date);
            $betTest->setYear(intval($duedt[0]));

            if($montanteid != null) {
                $em = $this->getDoctrine()->getManager();
                $palierMontanteRepository = $em->getRepository(PalierMontante::class);
                $palierMontante = $palierMontanteRepository->findOneBy(array('montante' => $montanteid, 'numberPalier' => $numberpalier));
                $palierMontante->setBetTest($betTest);
                $betTest->setPalierMontante($palierMontante);
                $em->persist($palierMontante);
            }

            $games = $betTest->getGamesTest();
            $countGames = count($games);
            $i = 0;
            foreach($games as $game) {
                if($game->getResultBet() == 'Valide') {
                    $i++;
                }
            }
            if($countGames == $i) {
                $betTest->setResultBet("Valide");
            }

            $betTestService->calculCoteBet($betTest);
            $betTestService->calculGain($betTest);

            if($montanteid != null){
                return $this->redirect($this->generateUrl('showmontante', array('id' => $palierMontante->getMontante()->getId())));
            }
            return $this->redirect($this->generateUrl('listebettest'));
        }
        return $this->render('bet_test/create.html.twig', array('my_form' => $formBetTest->createView()));
    }

    /**
     * @Route("/updatebettest/{id}", name="updatebettest")
     */
    public function update(Request $request, $id, BetTestService $betTestService): Response
    {
        $em = $this->getDoctrine()->getManager();
        $betTestRepository = $em->getRepository(BetTest::class);
        $betTest = $betTestRepository->find($id);

        $formBetTest = $this->createForm(BetTestType::class, $betTest);
        $formBetTest->add('creer', SubmitType::class, array('label' => 'Mise à jour du paris'));
        $formBetTest->remove('date');

        $formBetTest->handleRequest($request);

        if($request->isMethod('post') && $formBetTest->isValid()) {
            $games = $betTest->getGamesTest();
            $countGames = count($games);
            $i = 0;
            foreach($games as $game) {
                if($game->getResultBet() == 'Valide') {
                    $i++;
                }
            }
            if($countGames == $i) {
                $betTest->setResultBet("Valide");
            }

            $betTestService->calculCoteBet($betTest);
            $betTestService->calculGain($betTest);

            $this->addFlash('message', 'Paris mis à jour');
            
            return $this->redirect($this->generateUrl('listebettest'));
        }

        return $this->render('bet_test/create.html.twig', array('my_form' => $formBetTest->createView()));
    }

    /**
     * @Route("/deletebettest/{id}", name="deletebettest")
     * @Method({"POST", "DELETE"})
     */
    public function delete($id) 
    {
        $em = $this->getDoctrine()->getManager();
        $betTestRepository = $em->getRepository(BetTest::class);

        $betTest = $betTestRepository->find($id);

        $em->remove($betTest);
        $em->flush();

        return $this->redirectToRoute(('listebettest'));
    }
}
