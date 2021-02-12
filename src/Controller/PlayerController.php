<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\PlayerSearch;
use App\Form\PlayerType;
use App\Form\PlayerSearchType;
use App\Form\PlayerFileType;
use App\Service\FileUploader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlayerController extends AbstractController
{
    /**
     * @Route("/listeplayer", name="listeplayer")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $playerRepository = $em->getRepository(Player::class);

        $search = new PlayerSearch;
        $formSearch = $this->createForm(PlayerSearchType::class, $search);
        $formSearch->handleRequest($request);

        // Récupère tous les countries
        $data = $playerRepository->findAllVisibleQuery($search);

        $players = $paginator->paginate(
            $data, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10, // Nombre de résultats par page
            array(
                'defaultSortFieldName' => 'p.lastName',
                'defaultSortDirection' => 'asc',
            )
        );

        $players->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination)
            'size' => 'small', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);

        return $this->render('player/index.html.twig', array(
            'players' => $players,
            'formSearch' => $formSearch->createView()
        ));
    }

    /**
     * @Route("/createplayer", name="createplayer")
     */
    public function create(Request $request): Response
    {
        $player = New Player;
        $formPlayer = $this->createForm(PlayerType::class, $player);

        $formPlayer->add('creer', SubmitType::class, array('label' => 'Valider'));

        $formPlayer->handleRequest($request);

        if($request->isMethod('post') && $formPlayer->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($player);
            $em->flush();

            return $this->redirect($this->generateUrl('listeplayer'));
        }
        return $this->render('player/create.html.twig', array('my_form' => $formPlayer->createView()));
    }

    /**
     * @Route("/updateplayer/{id}", name="updateplayer")
     */
    public function update(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $playerRepository = $em->getRepository(Player::class);
        $player = $playerRepository->find($id);

        $formPlayer = $this->createForm(PlayerType::class, $player);

        $formPlayer->add('creer', SubmitType::class, array('label' => 'Mise à jour du joueur'));

        $formPlayer->handleRequest($request);

        if($request->isMethod('post') && $formPlayer->isValid()) {
            $em->persist($player);
            $em->flush();

            $this->addFlash('message', 'Joueur mis à jour');
            
            return $this->redirect($this->generateUrl('listeplayer'));
        }

        return $this->render('player/create.html.twig', array('my_form' => $formPlayer->createView()));
    }

    /**
     * @Route("/deleteplayer/{id}", name="deleteplayer")
     */
    public function delete(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $playerRepository = $em->getRepository((Player::class));
        $player = $playerRepository->find($id);

        $em->remove($player);
        $em->flush();

        $this->addFlash('message', 'Joueur supprimé');

        return $this->redirect($this->generateUrl('listeplayer'));
    }

    /**
     * @Route("/importplayer", name="importplayer")
     */
    public function import(Request $request, FileUploader $fileUploader)
    {
        $player = New Player;
        $formPlayer = $this->createForm(PlayerFileType::class, $player);

        $formPlayer->add('Importer', SubmitType::class, array('label' => 'Import des joueurs'));

        $formPlayer->handleRequest($request);

        if($request->isMethod('post') && $formPlayer->isValid()) 
        {
            $playerFile = $formPlayer->get('player')->getData();
            if ($playerFile) {
                $playerFileName = $fileUploader->upload($playerFile);

                $spreadsheet = IOFactory::load($this->getParameter('import_directory').'\\'.$playerFile); // Here we are able to read from the excel file 
                $row = $spreadsheet->getActiveSheet()->removeRow(1); // I added this to be able to remove the first file line 
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
                
                $em = $this->getDoctrine()->getManager(); 

                foreach ($sheetData as $Row) 
                { 
                    $firstName = $Row['A']; // store the name country on each iteration 
                    $lastName = $Row['B']; // store the name country on each iteration 
                    $team = $Row['C']; // store the name country on each iteration 

                    $player_existant = $em->getRepository(Player::class)->findOneBy(array('firstName' => $firstName, 'lastName' => $lastName)); 
                    // make sure that the user does not already exists in your db 
                    if (!$player_existant) 
                    {   
                        $player = new Player(); 
                        $player->setFirstName($firstName);      
                        $player->setFirstName($lastName);  
                        $player->setTeam($team);       
                        $em->persist($player); 
                        $em->flush(); 
                        // here Doctrine checks all the fields of all fetched data and make a transaction to the database.
                    } 
                }

                return $this->redirect($this->generateUrl('listeplayer'));
            }
    
            // ...
        }

        return $this->render('player/import.html.twig', array('my_form' => $formPlayer->createView()));
    }
}
