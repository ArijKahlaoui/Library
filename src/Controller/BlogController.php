<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo): Response
    {
        

        //$article = $repo->FindOneBy('titlre de l article');
        $articles = $repo->FindAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
        ]);
    }


    

    /**
     * @Route("/blog/new" , name="blog_create")
     * 
     */
        public function create(Request $request,EntityManagerInterface $manager){

            $article = new Article();

            $form = $this->createFormBuilder($article)
                         ->add('title')
                         ->add('auteur')
                         ->add('content')
                         ->add('image')
                         
                         ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $article-> setCreatedAt(new \DateTime());

                $manager->persist($article);
                $manager->flush();
                return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
            }
            return $this->render('blog/create.html.twig',[
                'formArticle' => $form->createView()
            ]);
        }



        /**
         * @Route("/blog/{id}/edit" , name="blog_edit")
         */
    public function form(Article $article, Request $request,EntityManagerInterface $manager){


        $form = $this->createFormBuilder($article)
                     ->add('title')
                     ->add('auteur')
                     ->add('content')
                     ->add('image')
                    
                     ->getForm();

        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId()){

                $article-> setCreatedAt(new \DateTime());
            }
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }
        return $this->render('blog/create.html.twig',[
            'formArticle' => $form->createView()
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article){

        return $this->render('blog/show.html.twig',[
            'article' => $article 
        ]);
    }

  /**
     * @Route("/blog/delete/{id}",name="delete_article")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
  
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();
  
        $response = new Response();
        $response->send();

        return $this->redirectToRoute('blog');
      }

}
