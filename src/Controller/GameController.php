<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Sport;
use App\Form\GameType;
use App\Entity\GameSearch;
use App\Form\GameSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GameController extends AbstractController
{
    /**
     * @Route("/listegame/{sportid}/{leagueid}", defaults={"sportid" = null, "leagueid" = null}, name="listegame")
     */
    public function index(Request $request, PaginatorInterface $paginator, $sportid, $leagueid): Response
    {
        $em = $this->getDoctrine()->getManager();
        $gameRepository = $em->getRepository(Game::class);
        $sportRepository = $em->getRepository(Sport::class);

        $search = new GameSearch();
        $formSearch = $this->createForm(GameSearchType::class, $search);
        $formSearch->handleRequest($request);

        // Récupère tous les countries
        if($leagueid != null){
            $data = $gameRepository->findByLeague($leagueid);
        }
        elseif($sportid != null) {
            $sport = new Sport;
            $sport = $sportRepository->findOneBy(array('id' => $sportid));
            $leagues = $sport->getLeagues();
            $data = $gameRepository->findBySport($leagues);
        }
        else {
            $data = $gameRepository->findAllVisibleQuery($search);
        }

        $games = $paginator->paginate(
            $data, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10, // Nombre de résultats par page
            array(
                'defaultSortFieldName' => 'g.date',
                'defaultSortDirection' => 'asc',
            )
        );

        $games->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination)
            'size' => 'small', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);

        return $this->render('game/index.html.twig', array(
            'games' => $games,
            'formSearch' => $formSearch->createView()
        ));
    }

    /**
     * @Route("/creategame", name="creategame")
     */
    public function create(Request $request): Response
    {
        $game = New Game;
        $formGame = $this->createForm(GameType::class, $game);

        $formGame->add('creer', SubmitType::class, array('label' => 'Valider'));

        $formGame->handleRequest($request);

        if($request->isMethod('post') && $formGame->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($game);
            $em->flush();

            return $this->redirect($this->generateUrl('listegame'));
        }
        return $this->render('game/create.html.twig', array('my_form' => $formGame->createView()));
    }

    /**
     * @Route("/updategame/{id}", name="updategame")
     */
    public function update(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $gameRepository = $em->getRepository(Game::class);
        $game = $gameRepository->find($id);

        $formGame = $this->createForm(GameType::class, $game);

        $formGame->add('creer', SubmitType::class, array('label' => 'Mise à jour du match'));

        $formGame->handleRequest($request);

        if($request->isMethod('post') && $formGame->isValid()) {
            $em->persist($game);
            $em->flush();

            $this->addFlash('message', 'Match mis à jour');
            
            return $this->redirect($this->generateUrl('listegame'));
        }

        return $this->render('game/create.html.twig', array('my_form' => $formGame->createView()));
    }

    /**
     * @Route("/deletegame/{id}", name="deletegame")
     */
    public function delete(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $gameRepository = $em->getRepository((Game::class));
        $game = $gameRepository->find($id);

        $em->remove($game);
        $em->flush();

        $this->addFlash('message', 'Match supprimé');

        return $this->redirect($this->generateUrl('listegame'));
    }
}
