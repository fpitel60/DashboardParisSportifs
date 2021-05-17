<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Entity\TeamSearch;
use App\Form\TeamFileType;
use App\Form\TeamSearchType;
use App\Service\FileUploader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeamController extends AbstractController
{
    /**
     * @Route("/listeteam", name="listeteam")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $teamRepository = $em->getRepository(Team::class);

        $search = new TeamSearch();
        $formSearch = $this->createForm(TeamSearchType::class, $search);
        $formSearch->handleRequest($request);

        // Récupère tous les countries
        $data = $teamRepository->findAllVisibleQuery($search);

        $teams = $paginator->paginate(
            $data, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10, // Nombre de résultats par page
            array(
                'defaultSortFieldName' => 't.name',
                'defaultSortDirection' => 'asc',
            )
        );

        $teams->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination)
            'size' => 'small', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);

        return $this->render('team/index.html.twig', array(
            'teams' => $teams,
            'formSearch' => $formSearch->createView()
        ));
    }

    /**
     * @Route("/createteam", name="createteam")
     */
    public function create(Request $request): Response
    {
        $team = New Team;
        $formTeam = $this->createForm(TeamType::class, $team);

        $formTeam->add('creer', SubmitType::class, array('label' => 'Valider'));

        $formTeam->handleRequest($request);

        if($request->isMethod('post') && $formTeam->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($team);
            $em->flush();

            return $this->redirect($this->generateUrl('listeteam'));
        }
        return $this->render('team/create.html.twig', array('my_form' => $formTeam->createView()));
    }

    /**
     * @Route("/updateteam/{id}", name="updateteam")
     */
    public function update(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $teamRepository = $em->getRepository(Team::class);
        $team = $teamRepository->find($id);

        $formTeam = $this->createForm(TeamType::class, $team);

        $formTeam->add('creer', SubmitType::class, array('label' => 'Mise à jour de l équipe'));

        $formTeam->handleRequest($request);

        if($request->isMethod('post') && $formTeam->isValid()) {
            $em->persist($team);
            $em->flush();

            $this->addFlash('message', 'Equipe mise à jour');
            
            return $this->redirect($this->generateUrl('listeteam'));
        }

        return $this->render('team/create.html.twig', array('my_form' => $formTeam->createView()));
    }

    /**
     * @Route("/deleteteam/{id}", name="deleteteam")
     */
    public function delete(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $teamRepository = $em->getRepository((Team::class));
        $team = $teamRepository->find($id);

        $em->remove($team);
        $em->flush();

        $this->addFlash('message', 'Equipe supprimé');

        return $this->redirect($this->generateUrl('listeteam'));
    }

    /**
     * @Route("/importteam", name="importteam")
     */
    public function import(Request $request, FileUploader $fileUploader)
    {
        $team = New Team;
        $formTeam = $this->createForm(TeamFileType::class, $team);

        $formTeam->add('Importer', SubmitType::class, array('label' => 'Import des ligues'));

        $formTeam->handleRequest($request);

        if($request->isMethod('post') && $formTeam->isValid()) 
        {
            $teamFile = $formTeam->get('league')->getData();
            if ($teamFile) {
                $teamFileName = $fileUploader->upload($teamFile);

                $spreadsheet = IOFactory::load($this->getParameter('import_directory').'\\'.$teamFile); // Here we are able to read from the excel file 
                $row = $spreadsheet->getActiveSheet()->removeRow(1); // I added this to be able to remove the first file line 
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
                
                $em = $this->getDoctrine()->getManager(); 

                foreach ($sheetData as $Row) 
                { 
                    $name = $Row['A']; // store the name country on each iteration 

                    $team_existant = $em->getRepository(Team::class)->findOneBy(array('name' => $name)); 
                    // make sure that the user does not already exists in your db 
                    if (!$team_existant) 
                    {   
                        $team = new Team(); 
                        $team->setName($name);           
                        $em->persist($team); 
                        $em->flush(); 
                        // here Doctrine checks all the fields of all fetched data and make a transaction to the database.
                    } 
                }

                return $this->redirect($this->generateUrl('listeteam'));
            }
    
            // ...
        }

        return $this->render('team/import.html.twig', array('my_form' => $formTeam->createView()));
    }
}
