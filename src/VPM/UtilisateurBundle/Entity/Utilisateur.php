<?php

namespace VPM\UtilisateurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\User;
/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="VPM\UtilisateurBundle\Repository\UtilisateurRepository")
 */
class Utilisateur extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="telPortable", type="string", length=10, nullable=true, unique=true)
     */
    private $telPortable;

    /**
     * @var string
     *
     * @ORM\Column(name="telFixe", type="string", length=10, nullable=true, unique=true)
     */
    private $telFixe;

    /**
     * @var bool
     *
     * @ORM\Column(name="newsletter", type="boolean")
     */
    private $newsletter;

    /**
     * @ORM\OneToMany(targetEntity="VPM\UtilisateurBundle\Entity\Adresse", mappedBy="utilisateur")
     */
    private $adresses;

    /**
     * @ORM\ManyToOne(targetEntity="VPM\UtilisateurBundle\Entity\Civilite")
     */
    private $civilite;
    
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
     * @return Utilisateur
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
     * @return Utilisateur
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
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Utilisateur
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Utilisateur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * Set telPortable
     *
     * @param string $telPortable
     *
     * @return Utilisateur
     */
    public function setTelPortable($telPortable)
    {
        $this->telPortable = $telPortable;

        return $this;
    }

    /**
     * Get telPortable
     *
     * @return string
     */
    public function getTelPortable()
    {
        return $this->telPortable;
    }

    /**
     * Set telFixe
     *
     * @param string $telFixe
     *
     * @return Utilisateur
     */
    public function setTelFixe($telFixe)
    {
        $this->telFixe = $telFixe;

        return $this;
    }

    /**
     * Get telFixe
     *
     * @return string
     */
    public function getTelFixe()
    {
        return $this->telFixe;
    }


    /**
     * Set newsletter
     *
     * @param boolean $newsletter
     *
     * @return Utilisateur
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return bool
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct();
        $this->adresses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add adress
     *
     * @param \VPM\UtilisateurBundle\Entity\Adresse $adress
     *
     * @return Utilisateur
     */
    public function addAdress(\VPM\UtilisateurBundle\Entity\Adresse $adress)
    {
        $this->adresses[] = $adress;

        return $this;
    }

    /**
     * Remove adress
     *
     * @param \VPM\UtilisateurBundle\Entity\Adresse $adress
     */
    public function removeAdress(\VPM\UtilisateurBundle\Entity\Adresse $adress)
    {
        $this->adresses->removeElement($adress);
        $adress->setUtilisateur($this);
    }

    /**
     * Get adresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdresses()
    {
        return $this->adresses;
    }
    
    /**
     * Retourne l'adresse de livraison de l'utilisateur
     * @return Adresse|NULL
     */
    public function getAdresseLivraison()
    {
    	foreach ($this->getAdresses() as $adresse)
    	{
    		if ($adresse->getType()->getLibelle() == "livraison")
    		{
    			return $adresse;
    		}
    	}
    	return null;
    }
    
    /**
     * Retourne l'adresse de facturation de l'utilisateur
     * @return Adresse|NULL
     */
    public function getAdresseFacturation()
    {
    	foreach ($this->getAdresses() as $adresse)
    	{
    		if ($adresse->getType()->getLibelle() == "facturation")
    		{
    			return $adresse;
    		}
    	}
    	return null;
    }

    /**
     * Set civilite
     *
     * @param \VPM\UtilisateurBundle\Entity\Civilite $civilite
     *
     * @return Utilisateur
     */
    public function setCivilite(\VPM\UtilisateurBundle\Entity\Civilite $civilite = null)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return \VPM\UtilisateurBundle\Entity\Civilite
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

  
}
