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

	public function recommandation() {

		$user = $this->get('security.token_storage')->getToken()->getUser();
        $results = $user->getLocations();
       
        // Starting last recommandation logic
        $tabId = [];	
        
        foreach ($results as $result) {
            array_push($tabId, $result->getId());
        }
        if ($tabId != []) {
        	$lastLocationId = max($tabId);
        	$lastOrderedRecommandation = $this->locationRepository->findOneBy([

        		'id' => $lastLocationId
        	]);
	    } else {
	    	$lastOrderedRecommandation = null;
	    }

	    // Starting Habbits recommandation
	    // Based on at least five last purschase
	    
	    // Faire une condition ternaire plus jolie
	    $maxTurn = 5;
	    if (sizeof($tabId) < $maxTurn)
	    {
	   		$maxTurn = sizeof($tabId);	
	    }

	    $fiveLocations = [];
        $tabType = [];
	    $tabOffre = [];
        $tabVille = [];
	    
	    if ($tabId != []) {
		    for ($i = 0; $i < $maxTurn; $i++) 
		    {
	        	$fiveLocations[$i] =  $this->locationRepository->find($tabId[$i]);
            	array_push($tabType, $fiveLocations[$i]->getVehicule()->getType()->getName());
            	array_push($tabOffre, $fiveLocations[$i]->getContrat()->getName());
            	array_push($tabVille, $fiveLocations[$i]->getVehicule()->getVille()->getName());
		    }
		}

			$tabType = array_count_values($tabType);
			$tabOffre = array_count_values($tabOffre);
			$tabVille = array_count_values($tabVille);
		
		if ($tabType  !=[] && $tabOffre  !=[] && $tabVille !=[]) 
		{  
		    $maxType = array_keys($tabType, max($tabType));
		    $maxOffre = array_keys($tabOffre, max($tabOffre));
		    $maxVille = array_keys($tabVille, max($tabVille));	

			// var_dump($tabOffre);

			// A refaire en beau ! mais fonctionne pour le moment 
			// Refacto !

		    switch ($maxType[0]) {
			    case "Trottinette":
			    	$a = 0; 
			    	$b = 0; 
			    	$c = 0; 
			    	foreach($tabOffre as $key => $value)
						{
						  if($key == "Trottinette A")
						  {
						  	$a += 1;
						  }
						  if($key == "Trottinette B")
						  {
						  	$b += 1;
						  }
						  if($key == "Trottinette C")
						  {
						  	$c += 1;
						  }
						  if ($a > $b && $a > $c) {
						  	$bestOffre = "Trottinette A";
						  	$idC = 7;
						  }
						  if ($b > $c) {
						  	$bestOffre = "Trottinette B";
						  	$idC = 8;
						  } 
						  elseif ( $c >= $b && $c >= $a) {
						  	$bestOffre = "Trottinette C";
						  	$idC = 9;
						  }
						}
				break;
			    case "Scooter":
			    	$a = 0; 
			    	$b = 0; 
			    	$c = 0; 
			    	foreach($tabOffre as $key => $value)
						{
						  if($key == 'Scooter A')
						  {
						  	$a += 1;
						  }
						  if($key == 'Scooter B')
						  {
						  	$b += 1;
						  }
						  if($key == 'Scooter C')
						  {
						  	$c += 1;
						  }
						  if ($a > $b && $a > $c) {
						  	$bestOffre = "Scooter A";
						  	$idC = 4;	
						  }
						  if ($b > $c) {
						  	$bestOffre = "Scooter B";
						  	$idC = 5;	
						  } 
						  elseif ( $c >= $b && $c >= $a) {
						  	$bestOffre = "Scooter C";
						  	$idC = 6;	
						  }
						}
			        break;
			    case "Voiture":
			    	$a = 0; 
			    	$b = 0; 
			    	$c = 0; 
			    	foreach($tabOffre as $key => $value)
						{
						  if($key == 'Voiture A')
						  {
						  	$a += 1;
						  }
						  if($key == 'Voiture B')
						  {
						  	$b += 1;
						  }
						  if($key == 'Voiture C')
						  {
						  	$c += 1;
						  }
						  if ($a > $b && $a > $c) {
						  	$bestOffre = "Voiture A";
						  	$idC = 1;	
						  }
						  if ($b > $c) {
						  	$bestOffre = "Voiture B";
						  	$idC = 2;	
						  } 
						  elseif ( $c >= $b && $c >= $a) {
						  	$bestOffre = "Voiture C";
						  	$idC = 3;	
						  }
						}
			        break;
			}
			}
			else 
			{
				$maxType[0] = null;
				$maxOffre[0] = null;
				$maxVille[0] = null;
				$bestOffre = null;
				$idC = null;
			}

			$codePromo = $user->getCodePromo();

			//var_dump($maxOffre["Trottinette B"]);
		    //var_dump($maxType[0]);
			//var_dump($maxOffre[0]);
			//var_dump($maxVille[0]);			

	        // var_dump($fiveLocations[0]->getId());

	    	// array_push($tabVille, $this->locationRepository->find($lastFiveId));
	   
	        return $this->render('recommandation/_recommandation.html.twig', [
	            'lastOrderedRecommandation' => $lastOrderedRecommandation,
	            /*/Based on at least 5 orders /*/
	            'mostType' => $maxType[0],
				'mostOffre' => $maxOffre[0],
				'mostVille' => $maxVille[0],
				'bestOffre' => $bestOffre,
				'codePromo' => $codePromo,
				'idC' => $idC,
	        ]);
	    }

	    /*
	    public function array_count_values_of($value, $array) {
		    $counts = array_count_values($array);
		    return $counts[$value];
		}
		*/
}