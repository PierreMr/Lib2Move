<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Location;
   
use App\Entity\User;
use App\Entity\Contrat;

use App\Form\FactureType;
use App\Form\PenaltyType;
use App\Repository\FactureRepository;

use App\Repository\LocationRepository;
use App\Repository\ContratRepository;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/facture")
 */
class FactureController extends Controller
{    

    /**
     * @Route("/", name="facture_index", methods={"GET"})
     */
    public function index(FactureRepository $factureRepository): Response
    {
        return $this->render('facture/index.html.twig', [
            'factures' => $factureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="facture_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($facture);
            $em->flush();

            return $this->redirectToRoute('facture_index');
        }

        return $this->render('facture/new.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facture_show", methods={"GET"})
     */
    public function show(Facture $facture): Response
    {
        return $this->render('facture/show.html.twig', [
            'facture' => $facture,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="facture_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Facture $facture): Response
    {
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('facture_index', [
                'id' => $facture->getId(),
            ]);
        }

        return $this->render('facture/edit.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/generate/{id}/", name="facture_generate", methods={"GET","POST"})
     */
    public function generate(Request $request, int $id, LocationRepository $locationRepository, ContratRepository $contratRepository, UserRepository $userRepository): Response
    {

        $facture = new Facture();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(PenaltyType::class, $facture);
        $location = $locationRepository->find($id);

        $kmFinalForm = $location->getVehicule()->getKilometers() + $location->getContrat()->getMaxKm();
        $form->get('km_final')->setData($kmFinalForm);
        $form->get('end_final')->setData($location->getEnd());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $km_final = $request->get("penalty")["km_final"];
            $end_final = $request->get("penalty")["end_final"];
            $end_final = new \Datetime($end_final);
        
            $location = new Location();
            $user = new User();
            $contrat = new Contrat();
            
            $location = $locationRepository->find($id);
            $locationId = $location->getId();

            $userId = $location->getUser();
            $user = $userRepository->find($userId);
            
            $userFirstname = $user->getFirstname();
            $userLastname = $user->getLastname();
            $userEmail = $user->getEmail();
            $userAddress = $user->getAddress();
            $userPhone = $user->getPhone();

            $vehiculeId = $location->getVehicule();
            $vehiculeTypeName = $location->getVehicule()->getType()->getName();
            $vehiculeBrand = $location->getVehicule()->getBrand();
            $vehiculeSerie = $location->getVehicule()->getSerie();
            $vehiculeLicensePlate = $location->getVehicule()->getLicensePlate();
            $vehiculeKilometers = $location->getVehicule()->getKilometers();
                 
            $villeName = $location->getVehicule()->getVille()->getName();

            $contratId = $location->getContrat()->getId();
            $contrat = $contratRepository->find($contratId);
            $contratName = $location->getContrat()->getName();
            $contratMaxKm = $location->getContrat()->getMaxKm();
            $contratMaxTime = $location->getContrat()->getMaxTime();
            $contratPrice = $location->getContrat()->getPrice();

            $contratKmPenalty = $location->getContrat()->getKmPenalty();
            $contratTimePenalty = $location->getContrat()->getTimePenalty();

            // From table location  
            $start = $location->getStart();
            $end = $location->getEnd();

            $finalePrice = $contratPrice;


            if($km_final > $vehiculeKilometers + $contratMaxKm) {   
                $finalePriceKm = ($km_final - ($vehiculeKilometers + $contratMaxKm)) * $contratKmPenalty;
                $finalePrice +=  $finalePriceKm;
            }
            if($end_final > $end) {                
                $interval = $end->diff($end_final);

                $minutes = $interval->format('%y') * 525600;
                $minutes += $interval->format('%m') * 43800;
                $minutes += $interval->format('%d') * 1440;
                $minutes += $interval->format('%H') * 60;
                $minutes += $interval->format('%i') * 1;


                $finalePriceTime = $minutes * $contratTimePenalty;
                $finalePrice +=  $finalePriceTime;
            }
            else {
                $minutes = 0;
            }
            
            $facture
                ->setUserId($userId)
                ->setUserEmail($userEmail)
                ->setUserLastname($userLastname)
                ->setUserFirstname($userFirstname)
                ->setUserAddress($userAddress)
                ->setUserPhone($userPhone)

                ->setVehiculeId($vehiculeId)
                ->setVehiculeName($vehiculeTypeName)
                ->setVehiculeKm($vehiculeKilometers)
                ->setBrand($vehiculeBrand)
                ->setSerie($vehiculeSerie)
                ->setLicencePlate($vehiculeLicensePlate)

                ->setContractId($contrat)
                ->setContractName($contratName)
                ->setMaxTime($contratMaxTime)
                ->setMaxKm($contratMaxKm)
                ->setPrice($contratPrice)
                ->setKmPenalty($contratKmPenalty)
                ->setTimePenalty($contratTimePenalty)

                ->setCityName($villeName)

                ->setLocationId($location)
                ->setStart($start)
                ->setEnd($end)
                ->setEndDiff($minutes)
                ->setEndFinal($end_final)
                ->setKmFinal($km_final)

                // proper facture data
                ->setPdf("path/to/.pdf")
                ->setTva(5.5)
                ->setFinalPrice($finalePrice)

               

                ->setStatus("X");                   
            
                $em->persist($facture);
                $em->flush();

            return $this->redirectToRoute('facture_index');
        }

        return $this->render('facture/new.html.twig', [
            'facture' => $facture,
            'location' => $location,
            'form' => $form->createView(),
        ]); 
    }

    /**
     * @Route("/pdf/{id}", name="facture_pdf", methods={"GET"})
     */
    public function pdf(Request $request, Facture $facture): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled', TRUE);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/facture.html.twig', [
            'facture' => $facture
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);

        exit;
    }

    /**
     * @Route("/pdftest/{id}", name="facture_pdftest", methods={"GET"})
     */
    public function pdftest(Request $request, Facture $facture): Response
    {
        return $this->render('pdf/facture.html.twig', [
            'facture' => $facture,
        ]);
    }

    /**
     * @Route("/{id}", name="facture_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Facture $facture): Response
    {
        if ($this->isCsrfTokenValid('delete'.$facture->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($facture);
            $em->flush();
        }

        return $this->redirectToRoute('facture_index');
    }
}
