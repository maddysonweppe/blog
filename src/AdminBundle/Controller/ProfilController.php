<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

use AdminBundle\Entity\Profil;
use AdminBundle\Form\ProfilType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ProfilController
 *
 * @author sebastien
 */
class ProfilController extends Controller {

    /**
     * @Route("/admin/{id}/profil", name="profil")
     * @Template("AdminBundle:profil:profil.html.twig")
     */
    public function profil($id) {

        $profil = $this->getDoctrine()->getRepository("AdminBundle:Profil")->findById($id);
        return array(
            "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
            'profil' => $profil,
        );
    }

    /**
     * @Route("/admin/{id}/form/profil", name="formProfil")
     * @Template("AdminBundle:profil:profilEditer.html.twig")
     */
    public function profilForm(Profil $profil) {
        $formProfil = $this->createForm(ProfilType::class, $profil);
        //  array qui lit la vue (cle => valeur)
        return array(
            'profil' => $this->getDoctrine()->getRepository("AdminBundle:Profil")->findById($profil),
            'id' => $profil->getId(),
            'formProfil' => $formProfil->createView(),
            "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
        );
    }

    /**
     * @Route("/admin/{id}/editer/profil", name="editerProfil")
     * @Template("AdminBundle:profil:profilEditer.html.twig")
     */
    public function profilEditer(Profil $profil, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $formProfil = $this->createForm(ProfilType::class, $profil);
        if ($request->getMethod() == 'POST') {
            $formProfil->handleRequest($request);
            $fichier = $profil->getAvatar();
            $nomDuFichier = md5(uniqid()) . "." . $fichier->guessExtension();
            $fichier->move(
                    $this->getParameter('avatars_directory'), $nomDuFichier
            );
            $profil->setAvatar($nomDuFichier);
            $prof = $formProfil->getData();
            $em->merge($prof);
            $em->flush();
            return $this->redirect($this->generateUrl('profil', array(
                                'id' => $prof->getId(),
                                "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
                            ))
            );
        }
        return $this->redirectToRoute('formProfil');
    }

    /**
     * @Route("/ajouterProfil", name="ajouterProfil")
     * @Template("AdminBundle:profil:profilAjouter.html.twig")
     */
    public function profilAjouter(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $profil = new Profil();
        $formProfil = $this->createForm(ProfilType::class, $profil);

        if ($request->getMethod() == 'POST') {
            $formProfil->handleRequest($request);
            $profil->setAvatar("../../externe/images/user.svg");

            $profil->setRole(array("ROLE_USER"));

//            $profil->setJaime(null);
            $em->persist($profil);
            $em->flush();
            return $this->redirect($this->generateUrl('home'));
        }
        return array(
            'formProfil' => $formProfil->createView(),
            "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
        );
    }

    /**
     * @Route("/admin/{id}/supprimer", name="supprimerProfil")
     * @Template("AdminBundle:profil:profilSupprimer.html.twig")
     */
    public function profilSupprimer($id) {
        $em = $this->getDoctrine()->getManager();
        $profil = $em->getRepository("AdminBundle:Profil")->findById($id);
        $em->remove($profil);
        $em->flush();
        return $this->redirect($this->generateUrl('home'));
    }

}
