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
     * @Route("/admin/categorie", name="category")
     * @Template("AdminBundle::categories.html.twig")
     */
    public function categorie() {
//        getRepository('AdminBundle:Categorie')findAll = "select * from Categorie"
        $categorie = $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll();
        $formCategorie = $this->createForm(CategorieType::class);
        return array(
            "formCategorie" => $formCategorie->createView(),
            "categories" => $categorie,
        );
    }

    /**
     * @Route("/admin/categorie/valide", name="valide")
     * @param Request $req
     */
    public function ajoutCategorie(Request $req) {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
//        on verifie que c'est une requete de type POST
        if ($req->getMethod() == 'POST') {
            $form->handleRequest($req);
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);// on persiste $categorie
            $em->flush();
            return $this->redirectToRoute('category');
        }
        return $this->redirectToRoute('category');
    }

    /**
     * @Route("/admin/categorie/{id}", name="edit")
     * @Template("AdminBundle::ajouter.html.twig")
     */
    public function editCategories($id) {
        $em = $this->getDoctrine()->getEntityManager();
//        on recupere par id dans la table categorie 
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
        $form = $this->createForm(CategorieType::class, $categorie);
        if ($req->getMethod() == 'POST') {
            $form->handleRequest($req);
            $em = $this->getDoctrine()->getEntityManager();
            $em->merge($categorie);
            $em->flush();
            return $this->redirect($this->generateUrl('category'));
        }
        return $this->redirectToRoute('category');
    }

    /**
     * @Route("/admin/categorie/supprimer/{id}", name="supp")
     */
    public function supprimerCategorie($id) {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->find("AdminBundle:Categorie", $id);
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute('category');
    }

}
