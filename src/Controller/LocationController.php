<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationType;
use App\Form\LocationAddType;
use App\Repository\LocationRepository;
use App\Repository\ContratRepository;
use App\Repository\VilleRepository;
use App\Repository\TypeVehiculeRepository;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/location")
 */
class LocationController extends AbstractController
{
    /**
     * @Route("/", name="location_index", methods={"GET"})
     */
    public function index(LocationRepository $locationRepository): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($user->getRoles() == ['ROLE_ADMIN'] || $user->getRoles() == ['ROLE_SUPERADMIN']) {
            $locations = $locationRepository->findAll();
        }
        else {
            $locations = $locationRepository->findBy(['user' => $user->getId()]);
        }

        return $this->render('location/index.html.twig', [
            'locations' => $locations,
        ]);
    }
    
    /**
     * @Route("/user", name="location_user", methods={"GET"})
     */
    public function user(LocationRepository $locationRepository): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $locations = $locationRepository->findBy(['user' => $user->getId()]);

        return $this->render('location/user.html.twig', [
            'locations' => $locations,
        ]);
    }

    /**
     * @Route("/add/{id}", name="location_add", methods={"GET","POST"})
     */
    public function add(Request $request, int $id, VehiculeRepository $vehiculeRepository, ContratRepository $contratRepository): Response
    {
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
    
        $loyaltyStamps = count($user->getLocations()) % 10;
        $promo = false;

        // hors teste le modumo doit valoire 1
        $loyaltyStamps === 9 ? $promo = true : $promo = false;
        
        $location = new Location();
        $form = $this->createForm(LocationAddType::class, $location);
        
        $vehicule = $vehiculeRepository->find($id);
        $form->get('vehicule')->setData($vehicule);

        $typeVehicule = $vehicule->getType()->getId();

        $contrats = $contratRepository->findBy(['type' => $typeVehicule ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('location_confirm', [
                'idV' => $request->get('location_add')['vehicule'],
                'idC' => $request->get('location_add')['contrat'],
            ]);
        }

        return $this->render('location/add.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
            'vehicule' => $vehicule,
            'contrats' => $contrats,
            'promo' => $promo
        ]);
    }

    /**
     * @Route("/recommandation/{idC}/{ville}/{type}", name="location_recommandation", methods={"GET","POST"})
     */
    public function location_from_recommandation(Request $request, int $idC, string $ville, string $type, VehiculeRepository $vehiculeRepository, ContratRepository $contratRepository, VilleRepository $villeRepository, TypeVehiculeRepository $typeVehiculeRepository): Response
    {

        $user = $this->get('security.token_storage')->getToken()->getUser(); 
        
        $location = new Location();

        $data = $request->get('location_add');
        
        $form = $this->createForm(LocationAddType::class, $location);

        $loyaltyStamps = count($user->getLocations()) % 10;
        $promo = false;
        $loyaltyStamps === 9 ? $promo = true : $promo = false;

        
        $nameType = $typeVehiculeRepository->findOneBy(
            [
                'name' => $type
            ]
        );
        $nameVille = $villeRepository->findOneBy(
            [
                'name' => $ville
            ]
        );
        
        $vehicules = $vehiculeRepository->findBy(
            // ['name' => 'Keyboard'],
            [
            'type' => $nameType->getId(),
            'ville' => $nameVille->getId()
            ]
        );
        
        //$form->get('vehicule')->setData($vehicule);
        
        $contrat = $contratRepository->find($idC);
        $form->get('contrat')->setData($contrat);

        $form->handleRequest($request);
        
        /*
        index vehicule dispo
        add $vehicule
        */
        if ($form->isSubmitted() && $form->isValid()) {

            
            $location->setUser($user);

            // $location->setVehicule($vehicule);
            $location->setContrat($contrat);

            $location->setStatus("En cours");

            if($promo){
            $location->setPromo(true);}

            $date = new \DatetimeImmutable();
            $location->setStart($date);
            $location->setEnd($date->add(new \DateInterval('P2D')));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($location);
            $entityManager->flush();

            return $this->redirectToRoute('location_index');
        }

        return $this->render('recommandation/location_from_recommandation.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
            'vehicules' => $vehicules,
            'contrat' => $contrat,
            //'promo' => $promo
        ]);
    }

    /**
     * @Route("/add_from_recommandation/{idV}/{idC}", name="location_add_from_recommandation", methods={"GET","POST"})
     */
    public function addFromRecommandation(Request $request, int $idV, int $idC, VehiculeRepository $vehiculeRepository, ContratRepository $contratRepository): Response
    {
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
    
        $loyaltyStamps = count($user->getLocations()) % 10;
        $promo = false;
        $loyaltyStamps === 9 ? $promo = true : $promo = false;
        
        $location = new Location();
        $form = $this->createForm(LocationAddType::class, $location);
        
        $vehicule = $vehiculeRepository->find($idV);
        $form->get('vehicule')->setData($vehicule);

        $typeVehicule = $vehicule->getType()->getId();

        $contrats = $contratRepository->findBy(['id' => $idC ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('location_confirm', [
                'idV' => $request->get('location_add')['vehicule'],
                'idC' => $request->get('location_add')['contrat'],
            ]);
        }

        return $this->render('location/add.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
            'vehicule' => $vehicule,
            'contrats' => $contrats,
            'promo' => $promo
        ]);
    }

    /**
     * @Route("/confirm/{idV}/{idC}", name="location_confirm", methods={"GET","POST"})
     */
    public function confirm(Request $request, int $idV, int $idC, VehiculeRepository $vehiculeRepository, ContratRepository $contratRepository): Response
    {


        $user = $this->get('security.token_storage')->getToken()->getUser();
        $loyaltyStamps = count($user->getLocations()) % 10;
        $promo = false;
        $loyaltyStamps === 9 ? $promo = true : $promo = false;
        
        $location = new Location();

        $data = $request->get('location_add');
        
        $form = $this->createForm(LocationAddType::class, $location);
        
        $vehicule = $vehiculeRepository->find($idV);
        $form->get('vehicule')->setData($vehicule);

        $contrat = $contratRepository->find($idC);
        $form->get('contrat')->setData($contrat);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /*
                \Stripe\Stripe::setApiKey("pk_test_TYooMQauvdEDq54NiTphI7jx");
                \Stripe\Charge::create(array(
                    "amont" => $contrat->getPrice(),
                    "currency" => "eur",
                    "source" => $request->request->get('stripeToken'),
                    "description" => "lib2move",
            ));
            */
            
            $location->setUser($user);
            $location->setVehicule($vehicule);
            $location->setContrat($contrat);
            $location->setStatus("En cours");
            $date = new \DatetimeImmutable();
            $location->setStart($date);
             if($promo){
            $location->setPromo(true);}

            $time = $contrat->getMaxTime();
            $hours = $time->format('H');
            $minutes = $time->format('i');
            $intervalString = 'PT'.$hours.'H'.$minutes.'M';
            $location->setEnd($date->add(new \DateInterval($intervalString)));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($location);
            $entityManager->flush();

            return $this->redirectToRoute('location_user');
        }

        return $this->render('location/confirm.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
            'vehicule' => $vehicule,
            'contrat' => $contrat,
            'promo' => $promo
        ]);
    }

    /**
     * @Route("/new", name="location_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $location->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($location);
            $entityManager->flush();

            return $this->redirectToRoute('location_index');
        }

        return $this->render('location/new.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="location_show", methods={"GET"})
     */
    public function show(Location $location): Response
    {
        return $this->render('location/show.html.twig', [
            'location' => $location,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="location_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Location $location): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('location_index', [
                'id' => $location->getId(),
            ]);
        }

        return $this->render('location/edit.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="location_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Location $location): Response
    {
        if ($this->isCsrfTokenValid('delete'.$location->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($location);
            $entityManager->flush();
        }

        return $this->redirectToRoute('location_index');
    }

   
}
