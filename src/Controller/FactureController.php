<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use App\Repository\FactureRepository;
use App\Repository\LocationRepository;
use App\Repository\ContratRepository;
use App\Repository\UserRepository;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/facture")
 */
class FactureController extends AbstractController
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
    public function generate(Request $request, int $id, LocationRepository $locationRepository, VehiculeRepository $vehiculeRepository, ContratRepository $contratRepository, UserRepository $userRepository): Response
    {

        $facture = new Facture();
      
        $em = $this->getDoctrine()->getManager();

        $facture
            ->setBrand("BMW")
            ->setContractName()
            ->setMaxTime()
            ->setMaxKm()
            ->setPrice()
            ->setKmPenalty()
            ->setTimePenalty()
            ->setCityName()
            ->setStart()
            ->setEnd()
            ->setKmEnd()
            ->setVehiculeName()
            ->setUserEmail()
            ->setUserLastname()
            ->setUserFirstname()
            ->setUserAdress()
            ->setUserPhone()
            ->setBrand()
            ->setSerie()
            ->setLicencePlate()
            ->setUserId()
            ->setVehiculeId()
            ->setContractId()
            ->setLocationId()
            ->setPdf()
            ->setTva()
            ->setFinalPrice()
            ->setEndFinal()
            ->setKmFinal()
            ->setTimeFinal()
            ->setStatus() ;                    
        
        $em->persist($facture);
        $em->flush();

        return $this->redirectToRoute('facture_index');
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
