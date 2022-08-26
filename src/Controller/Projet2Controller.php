<?php

namespace App\Controller;

use App\Repository\VehiculeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Projet2Controller extends AbstractController
{
    #[Route('/projet2', name: 'app_projet2')]
    public function index(VehiculeRepository $repo): Response
    {
        $vehicules = $repo->findAll();
        return $this->render('projet2/index.html.twig', [
            'tabVehicule' => $vehicules,
        ]);
    }

    #[Route('/', name: 'home')]
    public function home(VehiculeRepository $repo): response
    {
        $vehicules = $repo->findAll();
        return $this->render('projet2/home.html.twig',[
            'tabVehicule' => $vehicules,
        ]);
    }


}



