<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sport;
use App\Entity\SportSearch;
use App\Form\SportType;
use App\Form\SportFileType;
use App\Form\SportSearchType;
use App\Repository\SportRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Service\FileUploader;
use PhpOffice\PhpSpreadsheet\IOFactory;
// Nous avons besoin d'accéder à la requête pour obtenir le numéro de page
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator

class SportController extends AbstractController
{
    /**
     * @Route("/listesport", name="listesport")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $sportRepository = $em->getRepository(Sport::class);

        $search = new SportSearch();
        $formSearch = $this->createForm(SportSearchType::class, $search);
        $formSearch->handleRequest($request);

        // Récupère tous les countries
        $data = $sportRepository->findAllVisibleQuery($search);

        $sports = $paginator->paginate(
            $data, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10, // Nombre de résultats par page
            array(
                'defaultSortFieldName' => 's.name',
                'defaultSortDirection' => 'asc',
            )
        );

        $sports->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination)
            'size' => 'small', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);

        return $this->render('sport/index.html.twig', array(
            'sports' => $sports,
            'formSearch' => $formSearch->createView()
        ));
    }

    /**
     * @Route("/createsport", name="createsport")
     */
    public function create(Request $request): Response
    {
        $sport = New Sport;
        $formSport = $this->createForm(SportType::class, $sport);

        $formSport->add('creer', SubmitType::class, array('label' => 'Valider'));

        $formSport->handleRequest($request);

        if($request->isMethod('post') && $formSport->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($sport);
            $em->flush();

            return $this->redirect($this->generateUrl('listesport'));
        }
        return $this->render('sport/create.html.twig', array('my_form' => $formSport->createView()));
    }

    /**
     * @Route("/updatesport/{id}", name="updatesport")
     */
    public function update(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $sportRepository = $em->getRepository(Sport::class);
        $sport = $sportRepository->find($id);

        $formSport = $this->createForm(SportType::class, $sport);

        $formSport->add('creer', SubmitType::class, array('label' => 'Mise à jour du sport'));

        $formSport->handleRequest($request);

        if($request->isMethod('post') && $formSport->isValid()) {
            $em->persist($sport);
            $em->flush();

            //$session = $request->getSession();
            //$session->getFlashBag()->add('message', 'Sport mis à jour');
            //$session->set('statut', 'succes');

            $this->addFlash('message', 'Sport mis à jour');
            
            return $this->redirect($this->generateUrl('listesport'));
        }

        return $this->render('sport/create.html.twig', array('my_form' => $formSport->createView()));
    }

    /**
     * @Route("/deletesport/{id}", name="deletesport")
     */
    public function delete(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $sportRepository = $em->getRepository((Sport::class));
        $sport = $sportRepository->find($id);

        $em->remove($sport);
        $em->flush();

        $this->addFlash('message', 'Sport supprimé');

        return $this->redirect($this->generateUrl('listesport'));
    }

    /**
     * @Route("/importsport", name="importsport")
     */
    public function import(Request $request, FileUploader $fileUploader)
    {
        $sport = New Sport;
        $formSport = $this->createForm(SportFileType::class, $sport);

        $formSport->add('Importer', SubmitType::class, array('label' => 'Import des sports'));

        $formSport->handleRequest($request);

        if($request->isMethod('post') && $formSport->isValid()) 
        {
            $sportFile = $formSport->get('sport')->getData();
            if ($sportFile) {
                $sportFileName = $fileUploader->upload($sportFile);

                $spreadsheet = IOFactory::load($this->getParameter('import_directory').'\\'.$sportFileName); // Here we are able to read from the excel file 
                $row = $spreadsheet->getActiveSheet()->removeRow(1); // I added this to be able to remove the first file line 
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
                
                $em = $this->getDoctrine()->getManager(); 

                foreach ($sheetData as $Row) 
                { 
                    $name = $Row['A']; // store the name country on each iteration 

                    $sport_existant = $em->getRepository(Sport::class)->findOneBy(array('name' => $name)); 
                    // make sure that the user does not already exists in your db 
                    if (!$sport_existant) 
                    {   
                        $sport = new Sport(); 
                        $sport->setName($name);           
                        $em->persist($sport); 
                        $em->flush(); 
                        // here Doctrine checks all the fields of all fetched data and make a transaction to the database.
                    } 
                }

                return $this->redirect($this->generateUrl('listesport'));
            }
    
            // ...
        }

        return $this->render('sport/import.html.twig', array('my_form' => $formSport->createView()));
    }
}