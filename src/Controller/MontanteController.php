<?php

namespace App\Controller;

use App\Entity\Montante;
use App\Entity\PalierMontante;
use App\Form\MontanteType;
use App\Service\BetTest\BetTestService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MontanteController extends AbstractController
{
    /**
     * @Route("/listemontante", name="listemontante")
     */
    public function index(Request $request, BetTestService $betTestService, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $montanteRepository = $em->getRepository(Montante::class);

        $currentBankroll = $betTestService->getCurrentBankroll();
        $dataMontantes = $montanteRepository->findBy(array('bankroll' => $currentBankroll->getId()));

        $montantes = $paginator->paginate(
            $dataMontantes, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10, // Nombre de résultats par page
            array(
                'defaultSortFieldName' => 'm.dateStart',
                'defaultSortDirection' => 'desc',
            )
        );

        $montantes->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination)
            'size' => 'small', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);

        return $this->render('montante/index.html.twig', array(
            'montantes' => $montantes,
            'currentBankroll' => $currentBankroll
        ));
    }

    /**
     * @Route("/create/montante", name="createmontante")
     */
    public function create(Request $request, BetTestService $betTestService)
    {
        $currentBankroll = $betTestService->getCurrentBankroll();

        $montante = new Montante;

        $formMontante = $this->createForm(MontanteType::class, $montante);
        $formMontante->add('creer', SubmitType::class, array('label' => 'Valider'));

        $formMontante->handleRequest($request);

        if($request->isMethod('post') && $formMontante->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $montante->setBankroll($currentBankroll);

            for($i=1; $i<=$montante->getNbPalier(); $i++) {
                $palierMontante = new PalierMontante;
                $palierMontante->setNumberPalier($i);
                $palierMontante->setMontante($montante);
                $em->persist($palierMontante);
            }
            
            $em->persist($montante);
            $em->flush();
            
            return $this->redirect($this->generateUrl('listemontante'));
        }
        return $this->render('montante/create.html.twig', array('my_form' => $formMontante->createView()));
    }

    /**
     * @Route("/montante/show/{id}", name="showmontante")
     */
    public function show($id, BetTestService $betTestService)
    {
        $em = $this->getDoctrine()->getManager();
        $montanteRepository = $em->getRepository(Montante::class);
        $palierMontanteRepository = $em->getRepository(PalierMontante::class);

        $montante = $montanteRepository->find($id);
        $paliersMontante = $palierMontanteRepository->findBy(array('montante' => $id));

        return $this->render('montante/show.html.twig', array(
            'montante' => $montante,
            'paliersMontante' => $paliersMontante
        ));
    }
}
