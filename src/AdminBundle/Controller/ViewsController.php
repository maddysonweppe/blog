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
class ViewsController extends Controller {

    /**
     * @Route("/admin/accueil")
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
    
    /**
     * @Route("/admin/profil")
     * @Template("AdminBundle::profil.html.twig")
     */
    public function profil() {
        
    }
    
    /**
     * @Route("/admin/autreprofil")
     * @Template("AdminBundle::autreprofil.html.twig")
     */
    public function autreProfil() {
        
    }

    /**
     * @Route("/admin/likesprofil")
     * @Template("AdminBundle::likes.html.twig")
     */
    public function likesProfil() {
        
    }
    
    /**
     * @Route("/admin/article")
     * @Template("AdminBundle::article.html.twig")
     */
    public function article() {
        
    }
}
