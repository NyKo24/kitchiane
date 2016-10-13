<?php

namespace VPM\VehiculeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Modele
 *
 * @ORM\Table(name="modele")
 * @ORM\Entity(repositoryClass="VPM\VehiculeBundle\Repository\ModeleRepository")
 */
class Modele
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="VPM\VehiculeBundle\Entity\Cylindre", fetch="EAGER")
     */
    private $cylindre;

    /**
     * @ORM\ManyToOne(targetEntity="VPM\VehiculeBundle\Entity\Annee", cascade={"persist"}, fetch="EAGER")
     */
    private $annee;
    
    /**
     * @ORM\ManyToOne(targetEntity="VPM\VehiculeBundle\Entity\TypeVehicule", cascade={"persist"}, fetch="EAGER")
     */
    private $type;
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="VPM\VehiculeBundle\Entity\Constructeur", fetch="EAGER")
     */
    private $constructeur;
    
    

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Model
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Model
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * Set annee
     *
     * @param \VPM\VehiculeBundle\Entity\Annee $annee
     *
     * @return Model
     */
    public function setAnnee(\VPM\VehiculeBundle\Entity\Annee $annee = null)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return \VPM\VehiculeBundle\Entity\Annee
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set cylindre
     *
     * @param \VPM\VehiculeBundle\Entity\Cylindre $cylindre
     *
     * @return Modele
     */
    public function setCylindre(\VPM\VehiculeBundle\Entity\Cylindre $cylindre = null)
    {
        $this->cylindre = $cylindre;

        return $this;
    }

    /**
     * Get cylindre
     *
     * @return \VPM\VehiculeBundle\Entity\Cylindre
     */
    public function getCylindre()
    {
        return $this->cylindre;
    }

    /**
     * Set type
     *
     * @param \VPM\VehiculeBundle\Entity\TypeVehicule $type
     *
     * @return Modele
     */
    public function setType(\VPM\VehiculeBundle\Entity\TypeVehicule $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \VPM\VehiculeBundle\Entity\TypeVehicule
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set constructeur
     *
     * @param \VPM\VehiculeBundle\Entity\Constructeur $constructeur
     *
     * @return Modele
     */
    public function setConstructeur(\VPM\VehiculeBundle\Entity\Constructeur $constructeur = null)
    {
        $this->constructeur = $constructeur;

        return $this;
    }

    /**
     * Get constructeur
     *
     * @return \VPM\VehiculeBundle\Entity\Constructeur
     */
    public function getConstructeur()
    {
        return $this->constructeur;
    }
}
