<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Location;
use App\Repository\LocationRepository;



class RecommandationController extends AbstractController
{
	public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

	public function recommandationLast() {

		$user = $this->get('security.token_storage')->getToken()->getUser();

        $results = $user->getLocations();
       
        $tab = [];
        foreach ($results as $result) {
            array_push($tab, $result->getId());
        }
        if ($tab != []) {
        $lastLocationId = max($tab);
        $lastOrderedRecommandation = $this->locationRepository->find($lastLocationId);
	    } else {
	    	$lastOrderedRecommandation = null;
	    }
	        return $this->render('recommandation/_last_recommandation.html.twig', [
	            'lastOrderedRecommandation' => $lastOrderedRecommandation,
	        ]);
	    }
}