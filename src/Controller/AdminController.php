<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Commande;
use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\UserRepository;
use App\Controller\AdminController;
use App\Repository\CommandeRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/vehicule', name: 'admin_vehicules')]
    public function adminVehicule(VehiculeRepository $repo, EntityManagerInterface $manager)
    {
        $champs = $manager->getClassMetadata(Vehicule::class)->getFieldNames();
        //dd($champs);

        $vehicule = $repo-> findAll();
        return $this->render("admin/admin_vehicule.html.twig",[
            'vehicules' => $vehicule,
            'champs' => $champs
              ]);

    }

    #[Route('/admin/commande', name: 'admin_commande')]
    public function adminComande(CommandeRepository $repo, EntityManagerInterface $manager)
    {
        $champs = $manager->getClassMetadata(Commande::class)->getFieldNames();
        //dd($champs);

        $commande = $repo-> findAll();
        return $this->render("admin/admin_commande.html.twig",[
            'commandes' => $commande,
            'champs' => $champs
              ]);

    }

    // #[Route('/admin/membre', name: 'admin_membre')]
    // public function adminUser(UserRepository $repo, EntityManagerInterface $manager)
    // {
    //     $champs = $manager->getClassMetadata(User::class)->getFieldNames();
    //     //dd($champs);

    //     $commande = $repo-> findAll();
    //     return $this->render("admin/admin_membre.html.twig",[
    //         'membres' => $membre,
    //         'champs' => $champs
    //     ]);

    // }

    

    

    #[Route('/admin/vehicule/new', name:'admin_new_vehicule')]

    #[Route('/admin/vehicule/edit/{id}', name:'admin_edit_vehicule')]

public function vehicule_form(Vehicule $vehicule = null, Request $superglobals, EntityManagerInterface $manager)
{
   if($vehicule == null)
   {
       $vehicule = new Vehicule;
       $vehicule->setDateEnregistrement(new DateTime());

   }
   $form = $this->createForm(VehiculeType::class, $vehicule);
   $form->handleRequest($superglobals);
   if($form->isSubmitted() && $form->isValid())
   {
       $manager->persist($vehicule);
       $manager->flush();
       return $this->redirectToRoute('admin_vehicules');
   }

   return $this->renderForm("admin/vehicule_form.html.twig", [
       'formVehicule' => $form,
       'editMode' => $vehicule->getId() !== NULL
   ]);
}

 #[Route ("/admin/vehicule/delete/{id}", name: "admin_delete_vehicule")]

public function vehicule_delete(EntityManagerInterface $manager, VehiculeRepository $repo, $id)
    {
       $vehicule = $repo->find($id);

     $manager->flush();
       $this->addFlash('success', "le vehicule a bien ete supprimé");

       return $this->redirectToRoute("admin_vehicules");    }
}

