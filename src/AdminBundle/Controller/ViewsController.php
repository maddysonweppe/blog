<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AdminBundle\Controller;

use AdminBundle\Entity\Article;
use AdminBundle\Entity\Categorie;
use AdminBundle\Entity\Commentaire;
use AdminBundle\Entity\Profil;
use AdminBundle\Form\ArticleType;
use AdminBundle\Form\CategorieType;
use AdminBundle\Form\CommentaireType;
use AdminBundle\Form\ProfilType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ViewsController
 *
 * @author maddyson
 */
class ViewsController extends Controller {

    /**
     * @Route("/admin/accueil", name="adminHome")
     * @Template("AdminBundle::accueil.html.twig")
     */
    public function accueil() {
        
    }

    /**
     * @Route("/admin/categorie", name="categorie")
     * @Template("AdminBundle::categories.html.twig")
     */
    public function categorie() {
//        getRepository('AdminBundle:Categorie')findAll = "select * from Categorie"
        return array("categorie" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll());
    }

    /**
     * @Route("/admin/categorie/form", name="form")
     * @Template("AdminBundle::ajouter.html.twig")
     */
    public function formCategorie() {
//        on créé un nouveau formulaire pour les Categorie
        $categorie = $this->createForm(CategorieType::class);
        return array("formCategorie" => $categorie->createView());
    }

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
            return $this->redirectToRoute('form');
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

    /**
     * @Route("/admin/detailsArticles")
     * @Template("AdminBundle::detailsArticles.html.twig")
     */
    public function detailsArticles() {
        
    }

//    --------------PROFIL--------------
    /**
     * @Route("/{id}/profil", name="profil")
     * @Template("AdminBundle:profil:profil.html.twig")
     */
    public function profil($id) {
        $em = $this->getDoctrine()->getManager();
//  Pour l'utilisation du repository voir le README !
        $profil = $em->getRepository("AdminBundle:Profil")->findById($id);
        return array(
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
        if($request->getMethod() == 'POST'){
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
                            ))
            );
        }
//  array qui lit la vue (cle => valeur)
        return array(
            'id' => $profil->getId(),
            'formProfil' => $formProfil->createView()
        );
    }

    /**
     * @Route("/ajouterProfil")
     * @Template("AdminBundle:profil:profilAjouter.html.twig")
     */
    public function profilAjouter(Request $request) {
        $em = $this->getDoctrine()->getManager();
//  On doit afficher un formulaire avec des informations vierge 
//  donc on instancit un nouvel object
        $profil = new Profil();
        $formProfil = $this->createForm(ProfilType::class, $profil);

        if ($request->getMethod() == 'POST') {
            $formProfil->handleRequest($request);
//  Grace à la function / méthode "persist" on met les inforations
//  du formulaire en mémoire
            $em->persist($profil);
//  Puis on flush qui va sauvegarder en base de donnée
            $em->flush();
//  je retourne une redirection vers la vue que je veux via l'alias
            return $this->redirect($this->generateUrl('adminHome'));
        }
//  Toujours le même principe, cle => valeur pour lié à la vue
        return array(
            'formProfil' => $formProfil->createView()
        );
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

        return array(
            'profil' => $profil,
        );
    }

    /**
     * @Route("/{id}/delete", name="deleteProfil")
     * 
     */
    public function profilDeleteAction(Profil $profil) {
        $em = $this->getDoctrine()->getManager();
//  On utilise le fonction "remove()" pour supprimer
        $em->remove($profil);
//  Puis flush pour sauvegarder l'information qui est stocké en mémoire
//  Du coup on flush une suppression
        $em->flush();

        return $this->redirect($this->generateUrl('adminHome'));
    }

//    ------------ARTICLE--------------------
    /**
     * @Route("/home/article", name="articleHome")
     * @Template("AdminBundle:article:articleHome.html.twig")
     */
    public function articleHome() {
        return null;
    }

    /**
     * @Route("/{id}/article", name="article")
     * @Template("AdminBundle:article:article.html.twig")
     */
    public function article($id) {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository("AdminBundle:Article")->findById($id);
        return array(
            'article' => $article,
        );
    }

    /**
     * @Route("/article/ajouter", name="addArticle")
     * @Template("AdminBundle:article:articleAjouter.html.twig")
     */
    public function articleAjouter(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $article = new Article();
        $formArticle = $this->createForm(ArticleType::class, $article);
        $article->setBrouillon(1);
        if ($request->getMethod() == 'POST') {
            $formArticle->handleRequest($request);
            $em->persist($article);
            $em->flush();
            return $this->redirect($this->generateUrl('articleHome'));
        }

        return array(
            'formArticle' => $formArticle->createView()
        );
    }

    /**
     * @Route("/{id}/editer/article", name="articleEditer")
     * @Template("AdminBundle:article:articleEditer.html.twig")
     */
    public function articleEditer(Article $article, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $formArticle = $this->createForm(ArticleType::class, $article);

        if ($request->getMethod() == 'POST') {
            $formArticle->handleRequest($request);
            $a = $formArticle->getData();
            $em->merge($a);
            $em->flush();

            return $this->redirect($this->generateUrl('article', array(
                                'id' => $a->getId(),
                            ))
            );
        }
        return array(
            'id' => $article->getId(),
            'formArticle' => $formArticle->createView()
        );
    }

    /**
     * @Route("/{id}/articleDelete", name="articleDelete")
     * 
     */
    public function articleDeleteAction(Article $article) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        return $this->redirect($this->generateUrl('articleHome'));
    }

//    -----------COMMENTAIRE----------------------

    /**
     * @Route("/home/commentaire", name="commentaireHome")
     * @Template("AdminBundle:commentaire:commentaireHome.html.twig")
     */
    public function commentaireHome() {
        return null;
    }

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
     * @Route("/commentaire/ajouter", name="addCommentaire")
     * @Template("AdminBundle:commentaire:commentaireAjouter.html.twig")
     */
    public function commentaireAjouter(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $commentaire = new Commentaire();
        $formCommentaire = $this->createForm(CommentaireType::class, $commentaire);

        if ($request->getMethod() == 'POST') {
            $formCommentaire->handleRequest($request);
            $em->persist($commentaire);
            $em->flush();
            return $this->redirect($this->generateUrl('commentaireHome'));
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

    /**
     * @Route("/admin/likesprofil")
     * @Template("AdminBundle::likes.html.twig")
     */
    public function likesProfil() {
        
    }

    
    /**
     * @Route("/admin/articles")
     * @Template("AdminBundle::article.html.twig")
     */
    public function articleLol() {
        
    }
    
    /**
     * @Route("/admin/articlesBrouillons")
     * @Template("AdminBundle::articlesBrouillons.html.twig")
     */
    public function articleBrouillons() {
        
    }
    
        /**
     * @Route("/admin/commentairess")
     * @Template("AdminBundle::autreprofil.html.twig")
     */
    public function commentairesProfil() {
        
    }
}
