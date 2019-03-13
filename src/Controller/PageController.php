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
        $form->get('start')->setData(new \Datetime());
    	$form->handleRequest($request);

    	$vehicules = null;

        $user = $this->get('security.token_storage')->getToken()->getUser(); 

        if($user != "anon.") 
        {
            $loyaltyStamps = count($user->getLocations()) % 10;
            $promo = false;
            $loyaltyStamps === 9 ? $promo = true : $promo = false;
        } else {
            $promo = false;
        }

    	if($form->isSubmitted() && $form->isValid()) {
    		$vehicules = $vehiculeRepository->findSearchVehicule($search);
    	}
        //var_dump($loyaltyStamps);

        return $this->render('home.html.twig', [
        	'form' => $form->createView(),
        	'vehicules'=> $vehicules,
            'promo' => $promo,
        ]);
	}

	/**
     * @Route("/contact", name="app_contact")
     */
	public function contact(Request $request, \Swift_Mailer $mailer): Response
    {
    	$contact = new Contact();
    	$form = $this->createForm(ContactType::class, $contact);

        if ($this->get('security.token_storage')->getToken()->getUser() != 'anon.') {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $form->get('lastname')->setData($user->getLastname());
            $form->get('firstname')->setData($user->getFirstname());
            $form->get('email')->setData($user->getEmail());
            $form->get('phone')->setData($user->getPhone());
        }
        
    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()) {
            $mail = (new \Swift_Message('Contact'))
                ->setFrom('laville.pierre201@gmail.com')
                ->setTo($form->get('email')->getData())
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig',
                        [
                            'message' => $form->get('message')->getData(),
                            'lastname' => $form->get('lastname')->getData(),
                            'firstname' => $form->get('firstname')->getData(),
                        ]
                    ),
                    'text/html'
                )
            ;

            $mailUser = (new \Swift_Message('Contact'))
                ->setFrom($form->get('email')->getData())
                ->setTo('laville.pierre201@gmail.com')
                ->setBody(
                    $this->renderView(
                        'emails/contact-user.html.twig',
                        [
                            'message' => $form->get('message')->getData(),
                            'lastname' => $form->get('lastname')->getData(),
                            'firstname' => $form->get('firstname')->getData(),
                            'email' => $form->get('email')->getData(),
                            'phone' => $form->get('phone')->getData(),
                        ]
                    ),
                    'text/html'
                )
            ;

            $mailer->send($mailUser);

            if ($mailer->send($mail)) $this->addFlash('success', 'Email envoyé avec succès !');
            else $this->addFlash('danger', 'Une erreur est survenue');

            
    	}

        return $this->render('page/contact.html.twig', [
        	'form' => $form->createView(),
        ]);
	}

    
    public function recommandation() {

        $results = $user->getLocations();
       
        $tab = [];
        foreach ($results as $result) {
            array_push($tab, $result->getId());
        }
        $lastLocationId = max($tab);

        $lastOrderedRecommandation = $this->locationRepository->find($lastLocationId);

         return $this->renderView('recommandation/_recommandation.html.twig', [
            'data' => $lastOrderedRecommandation,
        ]);

    }
}