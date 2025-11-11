<?php

namespace App\Controller;

use App\Form\CovoiturageSearchType;
use App\Repository\CovoiturageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CovoiturageController extends AbstractController
{
    #[Route('/covoiturages', name: 'app_covoiturages')]
    public function index(Request $request, CovoiturageRepository $covoiturageRepository): Response
    {
        $form = $this->createForm(CovoiturageSearchType::class);
        $form->handleRequest($request);

        $covoiturages = $covoiturageRepository->findByFilters(
            $form->get('ecologique')->getData(),
            $form->get('prixMax')->getData(),
            $form->get('lieuDepart')->getData(),
            $form->get('lieuArrivee')->getData()
        );

        return $this->render('covoiturage/index.html.twig', [
            'covoiturages' => $covoiturages,
            'form' => $form->createView(),
        ]);
    }
}
