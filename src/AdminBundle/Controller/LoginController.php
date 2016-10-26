<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

use AdminBundle\Entity\Profil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Description of LoginController
 *
 * @author maddyson
 */
class LoginController extends Controller{

    /**
     * @Route("/addP",name="addP")
     * @throws Exception
     */
    public function addP() {
        $u = new Profil();
        $u->setEmail("Lencetre@gmail.com");
        $u->setMdp("user");
        $u->setRole(array("ROLE_USER"));
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($u);
        $em->flush();
        
        return $this->redirectToRoute("home");
    }
    
    /**
     * @Route("/loginCheck",name="loginCheck")
     * @throws Exception
     */
    public function check() {
        throw new Exception('Verifiez votre fichier security');
    }
    /**
     * @Route("/loginOut",name="loginOut")
     * @throws Exception
     */
    public function logout() {
        throw new Exception('Verifiez votre fichier security');
    }

}
