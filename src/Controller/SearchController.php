<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index(Request $request): Response
    {
        $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class,$propertySearch);
    $form->handleRequest($request);

    $articles= [];

    if($form->isSubmitted() && $form->isValid()) {
        $title = $propertySearch->getTitle();
        if ($title!="")
            //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
            $articles= $this->getDoctrine()->getRepository(Article::class)->findBy(['title' => $title] );
        else
            //si si aucun nom n'est fourni on affiche tous les articles
            $articles= $this->getDoctrine()->getRepository(Article::class)->findAll();
    }
    return $this->render('home/search.html.twig',[ 'form' =>$form->createView(), 'articles' => $articles]);
    }
    
}
