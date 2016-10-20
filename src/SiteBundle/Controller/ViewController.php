<?php

namespace SiteBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of ViewController
 *
 * @author fournival
 */
class ViewController extends Controller {
     /**
     * @Route("/home")
     * @Template("SiteBundle::generale.html.twig")
     */
    public function indexHome()
    {
        return null;
    }
    
     /**
     * @Route("/categories")
     * @Template("SiteBundle::categories.html.twig")
     */
    public function indexCategories()
    {
        return null;
    }
    
     /**
     * @Route("/login")
     * @Template("SiteBundle::connexion.html.twig")
     */
    public function indexLog()
    {
        return null;
    }
    
     /**
     * @Route("/{id}/detail")
     * @Template("SiteBundle::detail.html.twig")
     */
    public function indexDetail($id)
    {
               $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository("AdminBundle:Article")->findById($id);
        return array(
           'article' => $article,
       );
    }
    
}
