<?php

namespace App\Controller;

use App\Entity\TypeBet;
use App\Form\TypeBetType;
use App\Entity\TypeBetSearch;
use App\Form\TypeBetSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypeBetController extends AbstractController
{
    /**
     * @Route("/listetypebet", name="listetypebet")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $typeBetRepository = $em->getRepository(TypeBet::class);

        $search = new TypeBetSearch();
        $formSearch = $this->createForm(TypeBetSearchType::class, $search);
        $formSearch->handleRequest($request);

        // Récupère tous les countries
        $data = $typeBetRepository->findAllVisibleQuery($search);

        $typebets = $paginator->paginate(
            $data, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10, // Nombre de résultats par page
            array(
                'defaultSortFieldName' => 'tb.name',
                'defaultSortDirection' => 'asc',
            )
        );

        $typebets->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination)
            'size' => 'small', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);

        return $this->render('typebet/index.html.twig', array(
            'typebets' => $typebets,
            'formSearch' => $formSearch->createView()
        ));
    }

    /**
     * @Route("/createtypebet", name="createtypebet")
     */
    public function create(Request $request): Response
    {
        $typeBet = New TypeBet;
        $formTypeBet = $this->createForm(TypeBetType::class, $typeBet);

        $formTypeBet->add('creer', SubmitType::class, array('label' => 'Valider'));

        $formTypeBet->handleRequest($request);

        if($request->isMethod('post') && $formTypeBet->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($typeBet);
            $em->flush();

            return $this->redirect($this->generateUrl('listetypebet'));
        }
        return $this->render('typebet/create.html.twig', array('my_form' => $formTypeBet->createView()));
    }

    /**
     * @Route("/updatetypebet/{id}", name="updatetypebet")
     */
    public function update(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $typeBetRepository = $em->getRepository(TypeBet::class);
        $typeBet = $typeBetRepository->find($id);

        $formTypeBet = $this->createForm(TypeBetType::class, $typeBet);

        $formTypeBet->add('creer', SubmitType::class, array('label' => 'Mise à jour du type de paris'));

        $formTypeBet->handleRequest($request);

        if($request->isMethod('post') && $formTypeBet->isValid()) {
            $em->persist($typeBet);
            $em->flush();

            $this->addFlash('message', 'Type de paris mise à jour');
            
            return $this->redirect($this->generateUrl('listetypebet'));
        }

        return $this->render('typebet/create.html.twig', array('my_form' => $formTypeBet->createView()));
    }

    /**
     * @Route("/deletetypebet/{id}", name="deletetypebet")
     */
    public function delete(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $typeBetRepository = $em->getRepository((TypeBet::class));
        $typeBet = $typeBetRepository->find($id);

        $em->remove($typeBet);
        $em->flush();

        $this->addFlash('message', 'Type de paris supprimé');

        return $this->redirect($this->generateUrl('listetypebet'));
    }
}