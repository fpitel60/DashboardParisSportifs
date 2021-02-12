<?php

namespace App\Controller;

use App\Entity\TypeHighlight;
use App\Form\TypeHighlightType;
use App\Entity\TypeHighlightSearch;
use App\Form\TypeHighlightSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypeHighlightController extends AbstractController
{
    /**
     * @Route("/listetypehighlight", name="listetypehighlight")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $typeHighlightRepository = $em->getRepository(TypeHighlight::class);

        $search = new TypeHighlightSearch();
        $formSearch = $this->createForm(TypeHighlightSearchType::class, $search);
        $formSearch->handleRequest($request);

        // Récupère tous les countries
        $data = $typeHighlightRepository->findAllVisibleQuery($search);

        $typehighlights = $paginator->paginate(
            $data, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10, // Nombre de résultats par page
            array(
                'defaultSortFieldName' => 'th.name',
                'defaultSortDirection' => 'asc',
            )
        );

        $typehighlights->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination)
            'size' => 'small', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);

        return $this->render('type_highlight/index.html.twig', array(
            'typehighlights' => $typehighlights,
            'formSearch' => $formSearch->createView()
        ));
    }

    /**
     * @Route("/createtypehighlight", name="createtypehighlight")
     */
    public function create(Request $request): Response
    {
        $typeHighlight = New TypeHighlight;
        $formTypeHighlight = $this->createForm(TypeHighlightType::class, $typeHighlight);

        $formTypeHighlight->add('creer', SubmitType::class, array('label' => 'Valider'));

        $formTypeHighlight->handleRequest($request);

        if($request->isMethod('post') && $formTypeHighlight->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($typeHighlight);
            $em->flush();

            return $this->redirect($this->generateUrl('listetypehighlight'));
        }
        return $this->render('type_highlight/create.html.twig', array('my_form' => $formTypeHighlight->createView()));
    }

    /**
     * @Route("/updatetypehighlight/{id}", name="updatetypehighlight")
     */
    public function update(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $typeHighlightRepository = $em->getRepository(TypeHighlight::class);
        $typeHighlight = $typeHighlightRepository->find($id);

        $formTypeHighlight = $this->createForm(TypeHighlightType::class, $typeHighlight);

        $formTypeHighlight->add('creer', SubmitType::class, array('label' => 'Mise à jour du type de fait marquant'));

        $formTypeHighlight->handleRequest($request);

        if($request->isMethod('post') && $formTypeHighlight->isValid()) {
            $em->persist($typeHighlight);
            $em->flush();

            $this->addFlash('message', 'Type fait marquant mis à jour');
            
            return $this->redirect($this->generateUrl('listetypehighlight'));
        }

        return $this->render('type_highlight/create.html.twig', array('my_form' => $formTypeHighlight->createView()));
    }

    /**
     * @Route("/deletetypehighlight/{id}", name="deletetypehighlight")
     */
    public function delete(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $typeHighlightRepository = $em->getRepository((TypeHighlight::class));
        $typeHighlight = $typeHighlightRepository->find($id);

        $em->remove($typeHighlight);
        $em->flush();

        $this->addFlash('message', 'Type de fait marquant supprimé');

        return $this->redirect($this->generateUrl('listetypehighlight'));
    }
}
