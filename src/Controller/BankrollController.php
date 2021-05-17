<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Bankroll;
use App\Form\BankrollType;
use App\Service\BetTest\BetTestService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BankrollController extends AbstractController
{
    /**
     * @Route("/bankroll", name="bankroll")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $userRepository = $em->getRepository(User::class);
        
        $session = $request->getSession();
        $username = $session->get(Security::LAST_USERNAME);
        $user = $userRepository->findOneBy(array('username' => $username));

        $bankrolls = $user->getBankrolls();
        $defaultBankeroll = $user->getDefaultBankroll();

        return $this->render('bankroll/index.html.twig', array(
            'user' => $user,
            'bankrolls' => $bankrolls,
            'defaultBankroll' => $defaultBankeroll
        ));
    }

    /**
     * @Route("/bankroll/create", name="bankroll_create")
     */
    public function create(Request $request, BetTestService $betTestService)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $betTestService->getCurrentUser();

        $bankroll = new Bankroll;

        $formBankroll = $this->createForm(BankrollType::class, $bankroll);
        $formBankroll->add('creer', SubmitType::class, array('label' => 'Valider'));

        $formBankroll->handleRequest($request);

        if($request->isMethod('post') && $formBankroll->isValid()) {

            $session = $request->getSession();
            $bankroll->setCurrentBankroll($bankroll->getStartBankroll());
            if($user->getDefaultBankroll() == null){
                $user->setDefaultBankroll($bankroll);
            }

            $bankroll->setUser($user);

            $em->persist($bankroll);
            $em->flush();

            if($user->getDefaultBankroll() == null){
                $session->set('defaultBankrollId', $bankroll->getId());
            }
            $session->set('currentBankrollId', $bankroll->getId());

            return $this->redirect($this->generateUrl('listebettest'));
        }
        return $this->render('bankroll/create.html.twig', array('my_form' => $formBankroll->createView()));
    }

    /**
     * @Route("/bankroll/current/change/{id}", name="bankroll_current_change")
     */
    public function currentChange(Request $request, $id)
    {
        $session = $request->getSession();
        $session->set('currentBankrollId', $id);

        return $this->redirect($this->generateUrl('listebettest'));
    }

    /**
     * @Route("/bankroll/classement", name="bankroll_classement")
     */
    public function classement(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $bankrollRepository = $em->getRepository(Bankroll::class);

        $bankrolls = $bankrollRepository->findBy(array('visibility' => 'Public'), array('roi' => 'DESC'));

        $bankrolls = $paginator->paginate(
            $bankrollRepository->findBy(array('visibility' => 'Public'), array('roi' => 'DESC')), // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10, // Nombre de résultats par page
        );

        $bankrolls->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination)
            'size' => 'small', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);

        return $this->render('bankroll/classement.html.twig', array(
            'bankrolls' => $bankrolls
        ));
    }
}
