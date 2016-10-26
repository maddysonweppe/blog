<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

use AdminBundle\Entity\Article;
use AdminBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ArticleController
 *
 * @author sebastien
 */
class ArticleController extends Controller {

//    ------------ARTICLE--------------------
    /**
     * @Route("/home/article", name="articleHome")
     * @Template("AdminBundle:article:articleHome.html.twig")
     */
    public function articleHome() {
        return null;
    }

    /**
     * @Route("/article/form", name="formArticle")
     * @Template("AdminBundle:article:article.html.twig")
     */
    public function articleForm() {
        $formArticle = $this->createForm(ArticleType::class);
        return array(
            'formArticle' => $formArticle->createView(),
            "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
        );
    }
    /**
     * @Route("/article/ajouter{brouillon}", name="addArticle")
     * @Template("AdminBundle:article:article.html.twig")
     */
    public function articleAjouter(Request $request, $brouillon) {
        $em = $this->getDoctrine()->getManager();
        $article = new Article();
        $formArticle = $this->createForm(ArticleType::class, $article);
        
        if ($request->getMethod() == 'POST') {
            $article->setBrouillon($brouillon);
            $formArticle->handleRequest($request);
            $em->persist($article);
            $em->flush();
            return $this->redirect($this->generateUrl('home'));
        }
        return $this->redirectToRoute('ajouter',array(
            'formArticle' => $formArticle->createView(),
            "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
        ));
    }

    /**
     * @Route("/{id}/editer/article", name="articleEditer")
     * @Template("AdminBundle:article:articleEditer.html.twig")
     */
    public function articleEditer(Article $article, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $formArticle = $this->createForm(ArticleType::class, $article);
        
        if ($request->getMethod() == 'POST') {
            $formArticle->handleRequest($request);
            $a = $formArticle->getData();
            $em->merge($a);
            $em->flush();

            return $this->redirect($this->generateUrl('mesBrouillons', array(
                                'id' => $a->getId(),
                            ))
            );
        }
        return array(
            'id' => $article->getId(),
            'formArticle' => $formArticle->createView()
        );
    }
    
    /**
     * @Route("admin/publier{id}", name="publier")
     */
    public function publierArticle(Article $article) {
        $em = $this->getDoctrine()->getEntityManager();
        $this->createForm(ArticleType::class, $article);
        $article->setBrouillon(0);
        $em->merge($article);
        $em->flush();
        return $this->redirectToRoute("mesBrouillons");
    }
    
    /**
     * @Route("/{id}/articleDelete", name="articleDelete")
     * 
     */
    public function articleDeleteAction(Article $article) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return $this->redirect($this->generateUrl('articleHome'));
    }
//    
//    /**
//     * @Route("/{id}/modifier/article", name="articleModifier")
//     * @Template("AdminBundle:article:articleEditer.html.twig")
//     */
//    public function articleModifier(Article $article, Request $request) {
//        $em = $this->getDoctrine()->getManager();
//
//        $formArticle = $this->createForm(ArticleType::class, $article);
//
//        if ($request->getMethod() == 'POST') {
//            $formArticle->handleRequest($request);
//            $a = $formArticle->getData();
//            $em->merge($a);
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('article', array(
//                                'id' => $a->getId(),
//                            ))
//            );
//        }
//        return array(
//            'id' => $article->getId(),
//            'formArticle' => $formArticle->createView()
//        );
//    }

}
