<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuteurController extends AbstractController
{
   
    /**
     * @Route("/auteur", name="auteur")
     */
    public function index(AuteurRepository $repo): Response
    {
        

        //$article = $repo->FindOneBy('titlre de l article');
        $auteurs = $repo->FindAll();

        return $this->render('auteur/index.html.twig', [
            'controller_name' => 'AuteurController',
            'auteurs' => $auteurs,
        ]);
    }



    /**
     * @Route("/auteur/new" , name="auteur_create")
     * 
     */
    public function create(Request $request,EntityManagerInterface $manager){

        $auteur = new Auteur();

        $form = $this->createFormBuilder($auteur)
                     ->add('name')
                     ->add('informations')
                     
                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($auteur);
            $manager->flush();
            return $this->redirectToRoute('auteur_show', ['id' => $auteur->getId()]);
        }
        return $this->render('auteur/create.html.twig',[
            'formArticle' => $form->createView()
        ]);
    }



       /**
         * @Route("/auteur/{id}/edit" , name="auteur_edit")
         */
        public function form(Auteur $auteur, Request $request,EntityManagerInterface $manager){


            $form = $this->createFormBuilder($auteur)
                         ->add('name')
                         ->add('informations')
                        
                         ->getForm();
    
            $form->handleRequest($request);
    
            
            if($form->isSubmitted() && $form->isValid()){
                

                $manager->persist($auteur);
                $manager->flush();
                return $this->redirectToRoute('auteur_show', ['id' => $auteur->getId()]);
            }
            return $this->render('auteur/create.html.twig',[
                'formArticle' => $form->createView()
            ]);
        }


      /**
     * @Route("/auteur/{id}", name="auteur_show")
     */
    public function show(Auteur $auteur){

        return $this->render('auteur/show.html.twig',[
            'auteur' => $auteur 
        ]);
    }

     /**
     * @Route("/auteur/delete/{id}",name="delete_auteur")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $auteur = $this->getDoctrine()->getRepository(Auteur::class)->find($id);
  
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($auteur);
        $entityManager->flush();
  
        $response = new Response();
        $response->send();

        return $this->redirectToRoute('auteur');
      }
}
