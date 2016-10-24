<?php

namespace SiteBundle\Controller;

use AdminBundle\Entity\Article;
use AdminBundle\Entity\Commentaire;
use AdminBundle\Form\CommentaireType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ViewController
 *
 * @author fournival
 */
class ViewController extends Controller {
     /**
     * @Route("/", name="home")
     * @Template("SiteBundle::generale.html.twig")
     */
    public function indexHome()
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository("AdminBundle:Article")->findAll();
        return array(
            'article' => $article,
        );
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
     * @Route("/login", name="login")
     * @Template("SiteBundle::connexion.html.twig")
     */
    public function indexLog()
    {
        return null;
    }
    
    /**
     * @Route("/{id}/detail", name="idDetail")
     * @Template("SiteBundle::detail.html.twig")
     */
    public function indexDetail($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $article = $em->getRepository("AdminBundle:Article")->findById($id);
        $allCommentaire = $em->getRepository("AdminBundle:Commentaire")->findByArticle($id);
        
        $commentaire = new Commentaire();
        $formCommentaire = $this->createForm(CommentaireType::class, $commentaire);
        
        return array(
            'article' => $article,
            'commentaire' => $allCommentaire,
            'formCommentaire' => $formCommentaire->createView(),
        );
    }
}
