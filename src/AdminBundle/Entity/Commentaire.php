<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

//Pour afficher la date automatique voir la syntaxe du construct

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="texte", type="text")
     */
    private $texte;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Profil")
     * @ORM\JoinColumn(name="fk_pseudo", referencedColumnName="id")
     */
    private $pseudo;
    
    /**
     * @var array
     *
     * @ORM\Column(name="jaime", type="array", nullable=true)
     */
    private $jaime;
    
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="fk_article", referencedColumnName="id")
     */
    private $article;
    
    function getArticle() {
        return $this->article;
    }

    function setArticle($article) {
        $this->article = $article;
    }

        function getJaime() {
        return $this->jaime;
    }

    function setJaime($jaime) {
        $this->jaime = $jaime;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return Commentaire
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set texte
     *
     * @param string $texte
     *
     * @return Commentaire
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }

    /**
     * Get texte
     *
     * @return string
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return Commentaire
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }
    
    function __construct() {
        $this->date = new \DateTime();
    }
    
    public function __toString() {
        return $this->getPseudo();
    }

}

