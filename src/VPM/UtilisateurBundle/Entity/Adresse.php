<?php

namespace VPM\UtilisateurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adresse
 *
 * @ORM\Table(name="adresse")
 * @ORM\Entity(repositoryClass="VPM\UtilisateurBundle\Repository\AdresseRepository")
 */
class Adresse
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
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50,nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="societe", type="string", length=50, nullable=true)
     */
    private $societe;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=20, nullable=true)
     */
    private $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="tva", type="string", length=50, nullable=true)
     */
    private $tva;

    /**
     * @var string
     *
     * @ORM\Column(name="ligne1", type="string", length=255)
     */
    private $ligne1;

    /**
     * @var string
     *
     * @ORM\Column(name="ligne2", type="string", length=255, nullable=true)
     */
    private $ligne2;

    /**
     * @var string
     *
     * @ORM\Column(name="complement", type="string", length=255, nullable=true)
     */
    private $complement;
    
    /**
     * @var int
     *
     * @ORM\Column(name="cp", type="integer", nullable=false)
     */
    private $cp;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=false)
     */
    private $ville;

    /**
     * @var bool
     *
     * @ORM\Column(name="defaut", type="boolean")
     */
    private $defaut;

    /**
     * @ORM\ManyToOne(targetEntity="VPM\UtilisateurBundle\Entity\Utilisateur", inversedBy="adresses")
     */
    private $utilisateur;
    
    /**
     * @ORM\ManyToOne(targetEntity="VPM\UtilisateurBundle\Entity\TypeAdresse")
     */
    private $type;

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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Adresse
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Adresse
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set societe
     *
     * @param string $societe
     *
     * @return Adresse
     */
    public function setSociete($societe)
    {
        $this->societe = $societe;

        return $this;
    }

    /**
     * Get societe
     *
     * @return string
     */
    public function getSociete()
    {
        return $this->societe;
    }

    /**
     * Set siret
     *
     * @param string $siret
     *
     * @return Adresse
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Set tva
     *
     * @param string $tva
     *
     * @return Adresse
     */
    public function setTva($tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return string
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set ligne1
     *
     * @param string $ligne1
     *
     * @return Adresse
     */
    public function setLigne1($ligne1)
    {
        $this->ligne1 = $ligne1;

        return $this;
    }

    /**
     * Get ligne1
     *
     * @return string
     */
    public function getLigne1()
    {
        return $this->ligne1;
    }

    /**
     * Set ligne2
     *
     * @param string $ligne2
     *
     * @return Adresse
     */
    public function setLigne2($ligne2)
    {
        $this->ligne2 = $ligne2;

        return $this;
    }

    /**
     * Get ligne2
     *
     * @return string
     */
    public function getLigne2()
    {
        return $this->ligne2;
    }

    /**
     * Set complement
     *
     * @param string $complement
     *
     * @return Adresse
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;

        return $this;
    }

    /**
     * Get complement
     *
     * @return string
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * Set defaut
     *
     * @param boolean $defaut
     *
     * @return Adresse
     */
    public function setDefaut($defaut)
    {
        $this->defaut = $defaut;

        return $this;
    }

    /**
     * Get defaut
     *
     * @return bool
     */
    public function getDefaut()
    {
        return $this->defaut;
    }

    /**
     * Set utilisateur
     *
     * @param \VPM\UtilisateurBundle\Entity\Utilisateur $utilisateur
     *
     * @return Adresse
     */
    public function setUtilisateur(\VPM\UtilisateurBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \VPM\UtilisateurBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set type
     *
     * @param \VPM\UtilisateurBundle\Entity\TypeAdresse $type
     *
     * @return Adresse
     */
    public function setType(\VPM\UtilisateurBundle\Entity\TypeAdresse $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \VPM\UtilisateurBundle\Entity\TypeAdresse
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set cp
     *
     * @param integer $cp
     *
     * @return Adresse
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return integer
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Adresse
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }
}
