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

    //    --------------PROFIL--------------
    /**
     * @Route("/{id}/profil", name="profil")
     * @Template("AdminBundle:profil:profil.html.twig")
     */
    public function profil($id) {
        
        $profil = $this->getDoctrine()->getRepository("AdminBundle:Profil")->findById($id);
//        $user = $this->get('security.context')->getToken()->getUser();
//        $profil = $this->get('security.context')->getToken()->getUser();
        return array(
                    "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
                    'profil' => $profil,
        );
    }

    /**
     * @Route("/{id}/editer/profil", name="editerProfil")
     * @Template("AdminBundle:profil:profilEditer.html.twig")
     */
    public function profilEditer(Profil $profil, Request $request) {
//  Pour mainpuler un object on appellle la fonction ENTITY MANAGER 
//  qui est un gestionnaire d'entity
        $em = $this->getDoctrine()->getManager();
//  Dans une variable "$formProfil" on définit le formulaire à afficher
//  On a fait une génération de formulaire via le terminal sur l'entity Profil
//  On obtient un FormType qu'on utilise avec la syntaxe de dessous:
//  createForm(formtype, instance qui représente l'entity
        $formProfil = $this->createForm(ProfilType::class, $profil);
//  On dit que "Si c'est une méthode de type POST"
        if ($request->getMethod() == 'POST') {
//  Tu lies le formulaire à le requête
            $formProfil->handleRequest($request);
//  Tu récupère les information du formulaire(getData) dans une variable
            $prof = $formProfil->getData();
//  Pour mettre à jour une entity en base de donné, on fait un "merge"
//  c'est le même principe que pour "git"
//  On récupère les données de la variable qui contient le formulaire
//  Puis on merge avec les nouvelles donnée du formulaire pour écraser les encienne donnée
//  Pour l'instant, les données sont mis en mémoire
            $em->merge($prof);
//  Pour sauvegarder les données (qui sont en mémoire pour l'instant)
//  On flush, ce qui sauvegarde et écrase les nouvelles données en base de donnée 
            $em->flush();
//  Si tout c'est bien passé, on redirige vers l'alias (le name)
//  et on fait un array qui va servir de liaison pour la vue (cle => valeur)            
            return $this->redirect($this->generateUrl('profil', array(
                                'id' => $prof->getId(),
                                "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
                            ))
            );
//            return $this->redirect($this->generateUrl('profil', array(
//                                'id' => $prof->getId(),
//                                'profil' => $this->getRepository("AdminBundle:Profil")->findById($profil),
//                            ))
//            );
        }
//  array qui lit la vue (cle => valeur)
        return array(
            'profil' => $this->getDoctrine()->getRepository("AdminBundle:Profil")->findById($profil),
            'id' => $profil->getId(),
            'formProfil' => $formProfil->createView(),
            "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
        );
    }

    /**
     * @Route("/ajouterProfil", name="ajouterProfil")
     * @Template("template.html.twig")
     */
    public function profilAjouter(Request $request) {
        $em = $this->getDoctrine()->getManager();
//  On doit afficher un formulaire avec des informations vierge 
//  donc on instancit un nouvel object
        $profil = new Profil();
        $formProfil = $this->createForm(ProfilType::class, $profil);

        if ($request->getMethod() == 'POST') {
            $formProfil->handleRequest($request);


            $profil->setAvatar("../../externe/images/user.svg");

            $profil->setRole(array("ROLE_USER"));

            $profil->setJaime(null);
//  Grace à la function / méthode "persist" on met les inforations
//  du formulaire en mémoire
            $em->persist($profil);
//  Puis on flush qui va sauvegarder en base de donnée
            $em->flush();
//  je retourne une redirection vers la vue que je veux via l'alias
            return $this->redirect($this->generateUrl('connexion'));
        }
//  Toujours le même principe, cle => valeur pour lié à la vue
        return array(
            'formProfil' => $formProfil->createView(),
            "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
        );
    }

    public function editerAvatar(Request $request, $id) {
//  On doit supprimer un information en particulié, et non pas toute la base de donnée
//  On récupère par id pour supprimer par id dans la base de donnée
        $em = $this->getDoctrine()->getManager();
        $profil = $em->getRepository("AdminBundle:Profil")->findById($id);
        $formProfil = $this->createForm(ProfilType::class, $profil);

//  On utilise le fonction "remove()" pour supprimer
        if ($request->getMethod() == 'POST') {
            $formProfil->handleRequest($request);
            $nomDuFichier = md5(uniqid()) . "." . $profil->getAvatar()->getClientOriginalExtension();
            $profil->getAvatar()->move('uploads/img', $nomDuFichier);
            $profil->setAvatar($nomDuFichier);
//  Grace à la function / méthode "persist" on met les inforations
//  du formulaire en mémoire
            $em->persist($profil);
//  Puis on flush qui va sauvegarder en base de donnée
            $em->flush();
            return $this->redirect($this->generateUrl('connexion'));
        }
    }

    /**
     * @Route("/{id}/supprimer", name="supprimerProfil")
     * @Template("AdminBundle:profil:profilSupprimer.html.twig")
     */
    public function profilSupprimer($id) {
//  On doit supprimer un information en particulié, et non pas toute la base de donnée
//  On récupère par id pour supprimer par id dans la base de donnée
        $em = $this->getDoctrine()->getManager();
        $profil = $em->getRepository("AdminBundle:Profil")->findById($id);
//  On utilise le fonction "remove()" pour supprimer
        $em->remove($profil);
//  Puis flush pour sauvegarder l'information qui est stocké en mémoire
//  Du coup on flush une suppression
        $em->flush();

        return $this->redirect($this->generateUrl('home'));
    }

}
