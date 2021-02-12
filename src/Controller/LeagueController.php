<?php

namespace App\Controller;

use App\Entity\League;
use App\Form\LeagueType;
use App\Entity\LeagueSearch;
use App\Form\LeagueFileType;
use App\Service\FileUploader;
use App\Form\LeagueSearchType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// Nous avons besoin d'accéder à la requête pour obtenir le numéro de page
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator

class LeagueController extends AbstractController
{
    /**
     * @Route("/listeleague", name="listeleague")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $leagueRepository = $em->getRepository(League::class);

        $search = new LeagueSearch();
        $formSearch = $this->createForm(LeagueSearchType::class, $search);
        $formSearch->handleRequest($request);

        // Récupère tous les countries
        $data = $leagueRepository->findAllVisibleQuery($search);

        $leagues = $paginator->paginate(
            $data, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10, // Nombre de résultats par page
            array(
                'defaultSortFieldName' => 'l.name',
                'defaultSortDirection' => 'asc',
            )
        );

        $leagues->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination)
            'size' => 'small', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);

        return $this->render('league/index.html.twig', array(
            'leagues' => $leagues,
            'formSearch' => $formSearch->createView()
        ));
    }

    /**
     * @Route("/createleague", name="createleague")
     */
    public function create(Request $request): Response
    {
        $league = New League;
        $formLeague = $this->createForm(LeagueType::class, $league);

        $formLeague->add('creer', SubmitType::class, array('label' => 'Valider'));

        $formLeague->handleRequest($request);

        if($request->isMethod('post') && $formLeague->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($league);
            $em->flush();

            return $this->redirect($this->generateUrl('listeleague'));
        }
        return $this->render('league/create.html.twig', array('my_form' => $formLeague->createView()));
    }

    /**
     * @Route("/updateleague/{id}", name="updateleague")
     */
    public function update(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $leagueRepository = $em->getRepository(League::class);
        $league = $leagueRepository->find($id);

        $formLeague = $this->createForm(LeagueType::class, $league);

        $formLeague->add('creer', SubmitType::class, array('label' => 'Mise à jour de la ligue'));

        $formLeague->handleRequest($request);

        if($request->isMethod('post') && $formLeague->isValid()) {
            $em->persist($league);
            $em->flush();

            $this->addFlash('message', 'Ligue mise à jour');
            
            return $this->redirect($this->generateUrl('listeleague'));
        }

        return $this->render('league/create.html.twig', array('my_form' => $formLeague->createView()));
    }

    /**
     * @Route("/deleteleague/{id}", name="deleteleague")
     */
    public function delete(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $leagueRepository = $em->getRepository((League::class));
        $league = $leagueRepository->find($id);

        $em->remove($league);
        $em->flush();

        $this->addFlash('message', 'Ligue supprimé');

        return $this->redirect($this->generateUrl('listeleague'));
    }

    /**
     * @Route("/importleague", name="importleague")
     */
    public function import(Request $request, FileUploader $fileUploader)
    {
        $league = New League;
        $formLeague = $this->createForm(LeagueFileType::class, $league);

        $formLeague->add('Importer', SubmitType::class, array('label' => 'Import des ligues'));

        $formLeague->handleRequest($request);

        if($request->isMethod('post') && $formLeague->isValid()) 
        {
            $leagueFile = $formLeague->get('league')->getData();
            if ($leagueFile) {
                $leagueFileName = $fileUploader->upload($leagueFile);

                $spreadsheet = IOFactory::load($this->getParameter('import_directory').'\\'.$leagueFile); // Here we are able to read from the excel file 
                $row = $spreadsheet->getActiveSheet()->removeRow(1); // I added this to be able to remove the first file line 
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
                
                $em = $this->getDoctrine()->getManager(); 

                foreach ($sheetData as $Row) 
                { 
                    $name = $Row['A']; // store the name country on each iteration 

                    $league_existant = $em->getRepository(League::class)->findOneBy(array('name' => $name)); 
                    // make sure that the user does not already exists in your db 
                    if (!$league_existant) 
                    {   
                        $league = new League(); 
                        $league->setName($name);           
                        $em->persist($league); 
                        $em->flush(); 
                        // here Doctrine checks all the fields of all fetched data and make a transaction to the database.
                    } 
                }

                return $this->redirect($this->generateUrl('listeleague'));
            }
    
            // ...
        }

        return $this->render('league/import.html.twig', array('my_form' => $formLeague->createView()));
    }
}