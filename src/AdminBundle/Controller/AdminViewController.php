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

    /**
     * @Route("/admin/{id}/profil/likesprofil", name="mesLikes")
     */
    public function likesProfil() {
        return $this->render('AdminBundle::likes.html.twig', array(
                                //        getRepository('AdminBundle:Categorie')->findAll() = select * from Categorie
                    "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
        ));
    }

    /**
     * @Route("/admin/{id}/profil/articles", name="mesArticles")
     */
    public function articleLol() {
        return $this->render('AdminBundle::article.html.twig', array(
                    //        getRepository('AdminBundle:Categorie')->findAll() = select * from Categorie
                    "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
        ));
    }

    /**
     * @Route("/admin/articlesBrouillons", name="mesBrouillons")
     */
    public function articleBrouillons() {
        return $this->render('AdminBundle:article:articlesBrouillons.html.twig', array(
                    "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
                    //        getRepository('AdminBundle:Article')->findBy(array('brouillon' => 1), array("date" => "desc")) = select * from article where brouillon = 1 order by date DESC
                    "articles" => $this->getDoctrine()->getRepository('AdminBundle:Article')->findBy(array('brouillon' => 1), array("date" => "desc")),
        ));
    }

    /**
     * @Route("/admin/{id}/profil/mesArticles", name="mesArticles")
     */
    public function article() {
        return $this->render('SiteBundle::generale.html.twig', array(
                    "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
                    //        getRepository('AdminBundle:Article')->findBy(array(), array("date" => "desc")) = select * from article order by date DESC
                    "articles" => $this->getDoctrine()->getRepository('AdminBundle:Article')->findBy(array(), array("date" => "desc")),
        ));
    }

    /**
     * @Route("/admin/{id}/profil/commentaires", name="mesComs")
     */
    public function commentairesProfil($id) {

        return $this->render('AdminBundle::autreprofil.html.twig', array(
                    //        getRepository('AdminBundle:Categorie')findAll = "select * from Categorie"
                    "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
                    //        getRepository('AdminBundle:Commentaire')->findByPseudo($id) = select * from Commentaire where Pseudo = $id
                    "commentaires" => $this->getDoctrine()->getRepository('AdminBundle:Commentaire')->findByPseudo($id),
        ));
    }

}
