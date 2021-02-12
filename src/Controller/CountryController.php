<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Country;
use App\Entity\CountrySearch;
use App\Form\CountryType;
use App\Form\CountryFileType;
use App\Form\CountrySearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Service\FileUploader;
use PhpOffice\PhpSpreadsheet\IOFactory;
// Nous avons besoin d'accéder à la requête pour obtenir le numéro de page
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator


class CountryController extends AbstractController
{
    /**
     * @Route("/listecountry", name="listecountry")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $em = $this->getDoctrine()->getManager();
        $countryRepository = $em->getRepository(Country::class);

        $search = new CountrySearch();
        $formSearch = $this->createForm(CountrySearchType::class, $search);
        $formSearch->handleRequest($request);

        // Récupère tous les countries
        $data = $countryRepository->findAllVisibleQuery($search);

        $countries = $paginator->paginate(
            $data, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10, // Nombre de résultats par page
            array(
                'defaultSortFieldName' => 'c.name',
                'defaultSortDirection' => 'asc',
            )
        );

        $countries->setCustomParameters([
            'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination)
            'size' => 'small', # small|large (for template: twitter_bootstrap_v4_pagination)
            'style' => 'bottom',
            'span_class' => 'whatever',
        ]);

        return $this->render('country/index.html.twig', array(
            'countries' => $countries,
            'formSearch' => $formSearch->createView()
        ));
    }

    /**
     * @Route("/createcountry", name="createcountry")
     */
    public function create(Request $request): Response
    {
        $country = New Country;
        $formCountry = $this->createForm(CountryType::class, $country);

        $formCountry->add('creer', SubmitType::class, array('label' => 'Valider'));

        $formCountry->handleRequest($request);

        if($request->isMethod('post') && $formCountry->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($country);
            $em->flush();

            return $this->redirect($this->generateUrl('listecountry'));
        }
        return $this->render('country/create.html.twig', array('my_form' => $formCountry->createView()));
    }

    /**
     * @Route("/updatecountry/{id}", name="updatecountry")
     */
    public function update(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $countryRepository = $em->getRepository(Country::class);
        $country = $countryRepository->find($id);

        $formCountry = $this->createForm(CountryType::class, $country);

        $formCountry->add('creer', SubmitType::class, array('label' => 'Mise à jour du pays'));

        $formCountry->handleRequest($request);

        if($request->isMethod('post') && $formCountry->isValid()) {
            $em->persist($country);
            $em->flush();

            $this->addFlash('message', 'Pays mis à jour');
            
            return $this->redirect($this->generateUrl('listecountry'));
        }

        return $this->render('country/create.html.twig', array('my_form' => $formCountry->createView()));
    }

    /**
     * @Route("/deletecountry/{id}", name="deletecountry")
     */
    public function delete(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $countryRepository = $em->getRepository((Country::class));
        $country = $countryRepository->find($id);

        $em->remove($country);
        $em->flush();

        $this->addFlash('message', 'Pays supprimé');

        return $this->redirect($this->generateUrl('listecountry'));
    }

    /**
     * @Route("/importcountry", name="importcountry")
     */
    public function import(Request $request, FileUploader $fileUploader)
    {
        $country = New Country;
        $formCountry = $this->createForm(CountryFileType::class, $country);

        $formCountry->add('Importer', SubmitType::class, array('label' => 'Import des pays'));

        $formCountry->handleRequest($request);

        if($request->isMethod('post') && $formCountry->isValid()) 
        {
            $countryFile = $formCountry->get('country')->getData();
            if ($countryFile) {
                $countryFileName = $fileUploader->upload($countryFile);

                $spreadsheet = IOFactory::load($this->getParameter('import_directory').'\\'.$countryFileName); // Here we are able to read from the excel file 
                $row = $spreadsheet->getActiveSheet()->removeRow(1); // I added this to be able to remove the first file line 
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
                
                $em = $this->getDoctrine()->getManager(); 

                foreach ($sheetData as $Row) 
                { 
                    $name = $Row['A']; // store the name country on each iteration 
                    $countryCode = $Row['B']; // store the countryCode on each iteration

                    $country_existant = $em->getRepository(Country::class)->findOneBy(array('name' => $name)); 
                    // make sure that the user does not already exists in your db 
                    if (!$country_existant) 
                    {   
                        $country = new Country(); 
                        $country->setName($name);           
                        $country->setCountryCode(strtolower($countryCode));
                        $em->persist($country); 
                        $em->flush(); 
                        // here Doctrine checks all the fields of all fetched data and make a transaction to the database.
                    } 
                }

                return $this->redirect($this->generateUrl('listecountry'));
            }
    
            // ...
        }

        return $this->render('country/import.html.twig', array('my_form' => $formCountry->createView()));
    }
}