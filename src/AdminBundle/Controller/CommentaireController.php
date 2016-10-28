<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

use AdminBundle\Entity\Article;
use AdminBundle\Entity\Commentaire;
use AdminBundle\Form\CommentaireType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of CommentaireController
 *
 * @author sebastien
 */
class CommentaireController extends Controller {

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
     * @Route("/commentaire/ajouter/{id}", name="addCommentaire")
     */
    public function commentaireAjouter(Request $request, Article $article) {
        $em = $this->getDoctrine()->getManager();
        $commentaire = new Commentaire();
        $formCommentaire = $this->createForm(CommentaireType::class, $commentaire);
        
        if ($request->getMethod() == 'POST') {
            $formCommentaire->handleRequest($request);
            
            $commentaire->setArticle($article);
            
            $em->persist($commentaire);
            $em->flush();
            return $this->redirect($this->generateUrl('idDetail',array(
                'id' => $article->getId(),
            )));
        }

        return array(
            'formCommentaire' => $formCommentaire->createView()
        );
    }

    /**
     * @Route("/{id}/editer/commentaire", name="commentaireEditer")
     * @Template("AdminBundle:commentaire:commentaireEditer.html.twig")
     */
    public function commentaireEditer(Commentaire $commentaire, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $formCommentaire = $this->createForm(CommentaireType::class, $commentaire);

        if ($request->getMethod() == 'POST') {
            $formCommentaire->handleRequest($request);
            $c = $formCommentaire->getData();
            $em->merge($c);
            $em->flush();

            return $this->redirect($this->generateUrl('commentaire', array(
                                'id' => $c->getId(),
                            ))
            );
        }
        return array(
            'id' => $commentaire->getId(),
            'formCommentaire' => $formCommentaire->createView()
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
//    
//    /**
//     * 
//     * @Route("/saveCommentaire", name="sauvegardeCommentaire")
//     */
//    public function saveCommentaire(Request $request){
//        $em = $this->getDoctrine()->getManager();
//        $commentaire = new Commentaire();
//        
//        $formCommentaire = $this->createForm(CommentaireType::class, $commentaire);
//        
//      
//        
//        $formCommentaire->handleRequest($request);
//        
//        $em->persist($commentaire);
//        $em->flush();
//        
//        return $this->redirect($this->generateUrl('commentaireHome'));
//    }

}
