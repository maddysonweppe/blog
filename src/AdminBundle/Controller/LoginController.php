<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of LoginController
 *
 * @author maddyson
 */
class LoginController extends Controller{

    /**
     * @Route("/connexion", name="connexion")
     */
    public function indexLog() {

        return $this->render('SiteBundle::connexion.html.twig', array(
                    "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
        ));
    }

}
