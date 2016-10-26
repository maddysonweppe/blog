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
     */
    public function indexHome() {
        return $this->render('SiteBundle::generale.html.twig', array(
                    "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
                    "articles" => $this->getDoctrine()->getRepository('AdminBundle:Article')->findBy(array('brouillon'=> 0), array("date" => "desc")),
        ));
    }

    /**
     * @Route("/{categories}", name="categorie")
     */
    public function nav($categories) {
//        getRepository('AdminBundle:Categorie')->findByNom($categories)= select * from Categorie where nom = $categorie
        $id = $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findByNom($categories);
        return $this->render('SiteBundle::generale.html.twig', array(
//            getRepository('AdminBundle:Categorie')->findAll() = select * from Categorie
                    "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
//            getRepository('AdminBundle:Article')->findByCategorie($id, array("date"=>"desc"))= select * from Article where Categorie = $id order by date DESC
                    "articles" => $this->getDoctrine()->getRepository('AdminBundle:Article')->findByCategorie($id, array("date" => "desc")),
        ));
    }

    /**
     * @Route("/{id}/detail", name="idDetail")
     * @Template("SiteBundle::detail.html.twig")
     */
    public function indexDetail($id) {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository("AdminBundle:Article")->findById($id);
        $allCommentaire = $em->getRepository("AdminBundle:Commentaire")->findByArticle($id);

        $commentaire = new Commentaire();
        $formCommentaire = $this->createForm(CommentaireType::class, $commentaire);

        return array(
            'article' => $article,
            'commentaire' => $allCommentaire,
            'formCommentaire' => $formCommentaire->createView(),
            "categories" => $this->getDoctrine()->getRepository('AdminBundle:Categorie')->findAll(),
        );
    }

}
