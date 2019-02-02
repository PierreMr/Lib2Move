<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VehiculeRepository;
use App\Form\VehiculeSearchType;
use App\Form\ContactType;
use App\Entity\VehiculeSearch;
use App\Entity\Contact;

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

	/**
     * @Route("/contact", name="app_contact")
     */
	public function contact(Request $request): Response
    {
    	$contact = new Contact();
    	$form = $this->createForm(ContactType::class, $contact);

        if ($this->get('security.token_storage')->getToken()->getUser()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $form->get('lastname')->setData($user->getLastname());
            $form->get('firstname')->setData($user->getFirstname());
            $form->get('email')->setData($user->getEmail());
            $form->get('phone')->setData($user->getPhone());
        }
        
    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()) {
    		 $this->addFlash('danger', 'Server in progress !');

    	}

        return $this->render('page/contact.html.twig', [
        	'form' => $form->createView(),
        ]);
	}
}