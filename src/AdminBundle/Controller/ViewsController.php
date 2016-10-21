<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

use AdminBundle\Entity\Article;
use AdminBundle\Entity\Commentaire;
use AdminBundle\Entity\Profil;
use AdminBundle\Form\ArticleType;
use AdminBundle\Form\CommentaireType;
use AdminBundle\Form\ProfilType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ViewsController
 *
 * @author maddyson
 */
class ViewsController extends Controller {

    /**
     * @Route("/admin/accueil", name="adminHome")
     * @Template("AdminBundle::accueil.html.twig")
     */
    public function accueil() {
     
    }
    
    /**
     * @Route("/admin/categories")
     * @Template("AdminBundle::categories.html.twig")
     */
    public function categories() {
        
    }
    
    /**
     * @Route("/admin/detailsArticles")
     * @Template("AdminBundle::detailsArticles.html.twig")
     */
    public function detailsArticles() {
        
    }
//    --------------PROFIL--------------
    /**
     * @Route("/{id}/profil", name="profil")
     * @Template("AdminBundle:profil:profil.html.twig")
     */
    public function profil($id) {
          $em = $this->getDoctrine()->getManager();
//  grace au repository, je peux faire un select * from "table" where propriete:value
//  je veux récupérer les données de la data base par ID
//  je fais donc un "findById(id)" findBy"nom de la colum qui est dans l'entity"
//  exemple pour recup par amil: findByEmail("nom de l'email")/findByPseudo("nom du pseudo") ect...
          $profil = $em->getRepository("AdminBundle:Profil")->findById($id);
       return array(
           'profil' => $profil,
       );
    }
    /**
     * @Route("/{id}/editer/profil", name="editerProfil")
     * @Template("AdminBundle:profil:profilEditer.html.twig")
     */
    public function profilEditer(Profil $profil, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $formProfil = $this->createForm(ProfilType::class, $profil);

        if($request->getMethod() == 'POST'){
            $formProfil->handleRequest($request);
            $prof = $formProfil->getData();
            $em->merge($prof);
            $em->flush();
            
            return $this->redirect($this->generateUrl('profil', array(
                'id'    =>  $prof->getId(),
            ))
                    );
        }
        return array(
        'id'            => $profil->getId(),
        'formProfil'    => $formProfil->createView()
        );
    }
    
    /**
     * @Route("/ajouterProfil")
     * @Template("AdminBundle:profil:profilAjouter.html.twig")
     */
    public function profilAjouter(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $profil = new Profil();
        $formProfil = $this->createForm(ProfilType::class, $profil);
        
        if ($request->getMethod() == 'POST') {
            $formProfil->handleRequest($request);
            $em->persist($profil);
            $em->flush();
//      je retourne une redirection vers la vue que veux via l'alias
            return $this->redirect($this->generateUrl('adminHome'));
        }
        
        return array(
            'formProfil'    => $formProfil->createView()
        );
    }
    
    /**
     * @Route("/{id}/supprimer", name="supprimerProfil")
     * @Template("AdminBundle:profil:profilSupprimer.html.twig")
     */
    public function profilSupprimer($id) {
        $em = $this->getDoctrine()->getManager();
        
        $profil = $em->getRepository("AdminBundle:Profil")->findById($id);
       
        return array(
           'profil' => $profil,
       );
    }
    /**
     * @Route("/{id}/delete", name="deleteProfil")
     * 
     */
    public function profilDeleteAction(Profil $profil) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($profil);
        $em->flush();
        
        return $this->redirect($this->generateUrl('adminHome'));
    }
//    ------------ARTICLE--------------------
    /**
     * @Route("/home/article", name="articleHome")
     * @Template("AdminBundle:article:articleHome.html.twig")
     */
    public function articleHome() {
        return null;
    }
    /**
     * @Route("/{id}/article", name="article")
     * @Template("AdminBundle:article:article.html.twig")
     */
    public function article($id) {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository("AdminBundle:Article")->findById($id);
        return array(
           'article' => $article,
       );
    }
    
    /**
     * @Route("/article/ajouter", name="addArticle")
     * @Template("AdminBundle:article:articleAjouter.html.twig")
     */
    public function articleAjouter(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $article = new Article();
        $formArticle = $this->createForm(ArticleType::class, $article);
        
        if ($request->getMethod() == 'POST') {
            $formArticle->handleRequest($request);
            $em->persist($article);
            $em->flush();
            return $this->redirect($this->generateUrl('articleHome'));
        }
        
        return array(
            'formArticle'    => $formArticle->createView()
        );
    }
    
    /**
     * @Route("/{id}/editer/article", name="articleEditer")
     * @Template("AdminBundle:article:articleEditer.html.twig")
     */
    public function articleEditer(Article $article, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $formArticle = $this->createForm(ArticleType::class, $article);

        if($request->getMethod() == 'POST'){
            $formArticle->handleRequest($request);
            $a = $formArticle->getData();
            $em->merge($a);
            $em->flush();
            
            return $this->redirect($this->generateUrl('article', array(
                'id'    =>  $a->getId(),
            ))
                    );
        }
        return array(
        'id'            => $article->getId(),
        'formArticle'    => $formArticle->createView()
        );
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
//    -----------COMMENTAIRE----------------------
    
    /**
     * @Route("/home/commentaire", name="commentaireHome")
     * @Template("AdminBundle:commentaire:commentaireHome.html.twig")
     */
    public function commentaireHome() {
        return null;
    }
    /**
     * @Route("/{id}/commentaire", name="commentaire")
     * @Template("AdminBundle:commentaire:commentaire.html.twig")
     */
    public function commentaire($id) {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("AdminBundle:Commentaire")->findById($id);
        return array(
           'commentaire' => $commentaire,
       );
    }
    
    /**
     * @Route("/commentaire/ajouter", name="addCommentaire")
     * @Template("AdminBundle:commentaire:commentaireAjouter.html.twig")
     */
    public function commentaireAjouter(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $commentaire = new Commentaire();
        $formCommentaire = $this->createForm(CommentaireType::class, $commentaire);
        
        if ($request->getMethod() == 'POST') {
            $formCommentaire->handleRequest($request);
            $em->persist($commentaire);
            $em->flush();
            return $this->redirect($this->generateUrl('commentaireHome'));
        }
        
        return array(
            'formCommentaire'    => $formCommentaire->createView()
        );
    }
    
    /**
     * @Route("/{id}/editer/commentaire", name="commentaireEditer")
     * @Template("AdminBundle:commentaire:commentaireEditer.html.twig")
     */
    public function commentaireEditer(Commentaire $commentaire, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $formCommentaire = $this->createForm(CommentaireType::class, $commentaire);

        if($request->getMethod() == 'POST'){
            $formCommentaire->handleRequest($request);
            $c = $formCommentaire->getData();
            $em->merge($c);
            $em->flush();
            
            return $this->redirect($this->generateUrl('commentaire', array(
                'id'    =>  $c->getId(),
            ))
                    );
        }
        return array(
        'id'                    => $commentaire->getId(),
        'formCommentaire'       => $formCommentaire->createView()
        );
    }
    /**
     * @Route("/{id}/commentaireDelete", name="commentaireDelete")
     * 
     */
    public function commentaireDeleteAction(Commentaire $commentaire) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($commentaire);
        $em->flush();
        
        return $this->redirect($this->generateUrl('commentaireHome'));
    }
    

    /**
     * @Route("/admin/likesprofil")
     * @Template("AdminBundle::likes.html.twig")
     */
    public function likesProfil() {
        
    }
    
    /**
     * @Route("/admin/articles")
     * @Template("AdminBundle::article.html.twig")
     */
    public function articleLol() {
        
    }
    
    /**
     * @Route("/admin/articlesBrouillons")
     * @Template("AdminBundle::articlesBrouillons.html.twig")
     */
    public function articleBrouillons() {
        
    }
    
        /**
     * @Route("/admin/commentairess")
     * @Template("AdminBundle::autreprofil.html.twig")
     */
    public function commentairesProfil() {
        
    }
}
