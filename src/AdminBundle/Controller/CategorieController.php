<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

use AdminBundle\Entity\Categorie;
use AdminBundle\Form\CategorieType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of CategorieController
 *
 * @author sebastien
 */
class CategorieController extends Controller {

    /**
     * @Route("/admin/categorie", name="categorie")
     * @Template("AdminBundle::categories.html.twig")
     */
    public function categorie() {
//        getRepository('AdminBundle:Categorie')findAll = "select * from Categorie"
        $categorie = $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll();
       
        //        on créé un nouveau formulaire pour les Categorie
        $formCategorie = $this->createForm(CategorieType::class);
        return array("formCategorie" => $formCategorie->createView(),
            "categorie" => $categorie
        );
    }
//
//    /**
//     * @Route("/admin/categorie/form", name="form")
//     * @Template("AdminBundle::ajouter.html.twig")
//     */
//    public function formCategorie() {
////        on créé un nouveau formulaire pour les Categorie
//        $categorie = $this->createForm(CategorieType::class);
//        return array("formCategorie" => $categorie->createView());
//    }

    /**
     * @Route("/admin/categorie/valide", name="valide")
     * @param Request $req
     */
    public function ajoutCategorie(Request $req) {
//        on instancie un nouvelle objet categorie
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
//        on verifie que c'est une requete de type POST
        if ($req->getMethod() == 'POST') {
            $form->handleRequest($req);
            $em = $this->getDoctrine()->getManager();
//            
            $em->persist($categorie);
//            on enregistre
            $em->flush();
            return $this->redirectToRoute('categorie');
        }
        return $this->redirectToRoute('categorie');
    }

    /**
     * @Route("/admin/categorie/{id}", name="edit")
     * @Template("AdminBundle::ajouter.html.twig")
     */
    public function editCategories($id) {
        $em = $this->getDoctrine()->getEntityManager();
//        find('AdminBundle:Categorie', $id) == on cherche par id dans la table categorie 
        $categorie = $em->find('AdminBundle:Categorie', $id);
        $form = $this->createForm(CategorieType::class, $categorie);
//        on créé une une a partir du formulaire pré-remplie avec l'id
        return array("formCategorie" => $form->createView(), "id" => $id);
    }

    /**
     * @Route("/admin/categorie/maj/{id}", name="maj")
     * @param Request $req
     */
    public function majCategorie(Request $req, $id) {
        $em = $this->getDoctrine()->getEntityManager();
        $categorie = $em->find('AdminBundle:Categorie', $id);
        $biere = $this->createForm(CategorieType::class, $categorie);
        if ($req->getMethod() == 'POST') {
            $biere->handleRequest($req);
            $em = $this->getDoctrine()->getEntityManager();
//          on fusionne les entity categorie
            $em->merge($categorie);
            $em->flush();
            return $this->redirect($this->generateUrl('maj'));
        }
        return $this->redirectToRoute('categorie');
    }

    /**
     * @Route("/admin/categorie/supprimer/{id}", name="supp")
     */
    public function supprimerCategorie($id) {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->find("AdminBundle:Categorie", $id);
//        on supprime la categorie
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute('categorie');
    }

}
