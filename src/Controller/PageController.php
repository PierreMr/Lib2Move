<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VehiculeRepository;
use App\Form\VehiculeSearchType;
use App\Entity\VehiculeSearch;

class PageController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function home(VehiculeRepository $vehiculeRepository, Request $request): Response
    {
    	$search = new VehiculeSearch();
    	$form = $this->createForm(VehiculeSearchType::class, $search);
    	$form->handleRequest($request);

    	$vehicules = null;

    	if($form->isSubmitted() && $form->isValid()) {
    		$vehicules = $vehiculeRepository->findSearchVehicule($search);
    	}

        return $this->render('home.html.twig', [
        	'form' => $form->createView(),
        	'vehicules'=> $vehicules,
        ]);
	}
}