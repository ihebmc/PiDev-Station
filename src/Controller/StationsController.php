<?php

namespace App\Controller;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Station;
use App\Form\StationType;
use App\Repository\StationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stations')]
class StationsController extends AbstractController
{
    #[Route('/', name: 'app_stations_index', methods: ['GET'])]
    public function index(StationRepository $stationRepository): Response
    {
        return $this->render('stations/index.html.twig', [
            'stations' => $stationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_stations_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StationRepository $stationRepository): Response
    {
        $station = new Station();
        $form = $this->createForm(StationType::class, $station);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $stationRepository->save($station, true);
    
            return $this->redirectToRoute('app_stations_index', [], Response::HTTP_SEE_OTHER);
        }
        
        // Add form validation to check that fields are not empty
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'The form contains errors.');
        }
    
        return $this->renderForm('stations/new.html.twig', [
            'station' => $station,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_stations_show', methods: ['GET'])]
    public function show(Station $station): Response
    {
        return $this->render('stations/show.html.twig', [
            'station' => $station,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Station $station, StationRepository $stationRepository): Response
    {
        $form = $this->createForm(StationType::class, $station);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $stationRepository->save($station, true);
    
            return $this->redirectToRoute('app_stations_index', [], Response::HTTP_SEE_OTHER);
        }
        
        // Add form validation to check that fields are not empty
        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'The form contains errors.');
        }
    
        return $this->renderForm('stations/edit.html.twig', [
            'station' => $station,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_stations_delete', methods: ['POST'])]
    public function delete(Request $request, Station $station, StationRepository $stationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$station->getId(), $request->request->get('_token'))) {
            $stationRepository->remove($station, true);
        }

        return $this->redirectToRoute('app_stations_index', [], Response::HTTP_SEE_OTHER);
    }
//     /**
//  * @Route("/category/newCat", name="new_category")
//  * Method({"GET", "POST"})
//  */
//  public function newCategory(Request $request) {
//     $category = new Category();
//     $form = $this->createForm(CategoryType::class,$category);
//     $form->handleRequest($request);
//     if($form->isSubmitted() && $form->isValid()) {
//     $station = $form->getData();
//     $entityManager = $this->getDoctrine()->getManager();
//     $entityManager->persist($category);
//     $entityManager->flush();
//     }
//    return $this->render('Station/newCategory.html.twig',['form'=>
//    $form->createView()]);
//     }
   
}
