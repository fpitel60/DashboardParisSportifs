<?php

namespace App\Controller;

use App\Entity\Bookmaker;
use App\Form\BookmakerType;
use App\Entity\BookmakerSearch;
use App\Form\BookmakerSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookmakerController extends AbstractController
{
    /**
     * @Route("/bookmaker", name="bookmaker")
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $bookmakerRepository = $em->getRepository(Bookmaker::class);

        // Récupère tous les bookmakers
        $bookmakers = $bookmakerRepository->findAll();

        return $this->render('bookmaker/index.html.twig', array(
            'bookmakers' => $bookmakers,
        ));
    }

    /**
     * @Route("/bookmaker/create", name="bookmaker_create")
     */
    public function create(Request $request)
    {
        $bookmaker = New Bookmaker;
        $formBookmaker = $this->createForm(BookmakerType::class, $bookmaker);

        $formBookmaker->add('creer', SubmitType::class, array('label' => 'Valider'));

        $formBookmaker->handleRequest($request);

        if($request->isMethod('post') && $formBookmaker->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($bookmaker);
            $em->flush();

            return $this->redirect($this->generateUrl('bookmaker'));
        }
        return $this->render('bookmaker/create.html.twig', array('my_form' => $formBookmaker->createView()));
    }

    /**
     * @Route("/bookmaker/update/{id}", name="bookmaker_update")
     */
    public function update(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $bookmakerRepository = $em->getRepository(Bookmaker::class);
        $bookmaker = $bookmakerRepository->find($id);

        $formBookmaker = $this->createForm(BookmakerType::class, $bookmaker);

        $formBookmaker->add('creer', SubmitType::class, array('label' => 'Mise à jour du bookmaker'));

        $formBookmaker->handleRequest($request);

        if($request->isMethod('post') && $formBookmaker->isValid()) {
            $em->persist($bookmaker);
            $em->flush();

            $this->addFlash('message', 'Bookmaker mis à jour');
            
            return $this->redirect($this->generateUrl('bookmaker'));
        }

        return $this->render('bookmaker/create.html.twig', array('my_form' => $formBookmaker->createView()));
    }

    /**
     * @Route("/bookmaker/delete/{id}", name="bookmaker_delete")
     */
    public function delete(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $bookmakerRepository = $em->getRepository((Bookmaker::class));
        $bookmaker = $bookmakerRepository->find($id);

        $em->remove($bookmaker);
        $em->flush();

        $this->addFlash('message', 'Bookmaker supprimé');

        return $this->redirect($this->generateUrl('bookmaker'));
    }
}
