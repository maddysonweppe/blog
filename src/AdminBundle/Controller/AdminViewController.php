<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of ViewsController
 *
 * @author maddyson
 */
class AdminViewController extends Controller {
//
//    /**
//     * @Route("/admin/accueil", name="adminHome")
//     * @Template("AdminBundle::accueil.html.twig")
//     */
//    public function accueil() {
//        
//    }

    /**
     * @Route("/admin/{id}/profil/detailsArticles")
     * @Template("AdminBundle::detailsArticles.html.twig")
     */
    public function detailsArticles() {
        
    }

    /**
     * @Route("/admin/{id}/profil/likesprofil", name="mesLikes")
     * @Template("AdminBundle::likes.html.twig")
     */
    public function likesProfil() {
        
    }
    
    /**
     * @Route("/admin/{id}/profil/articles", name="mesArticles")
     * @Template("AdminBundle::article.html.twig")
     */
    public function articleLol() {
        
    }
    
    /**
     * @Route("/admin/{id}/profil/articlesBrouillons", name="mesBrouillons")
     * @Template("AdminBundle::articlesBrouillons.html.twig")
     */
    public function articleBrouillons() {
        
    }
    
        /**
     * @Route("/admin/{id}/profil/commentaires", name="mesComs")
     * @Template("AdminBundle::autreprofil.html.twig")
     */
    public function commentairesProfil() {
        
    }
}
