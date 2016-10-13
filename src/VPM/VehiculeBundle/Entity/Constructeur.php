<?php

namespace VPM\VehiculeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Constructeur
 *
 * @ORM\Table(name="constructeur")
 * @ORM\Entity(repositoryClass="VPM\VehiculeBundle\Repository\ConstructeurRepository")
 */
class Constructeur
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
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="VPM\VehiculeBundle\Entity\Modele", mappedBy="constructeur")
     */
	private $modele;
	
	/**
	 * @ORM\OneToMany(targetEntity="VPM\VehiculeBundle\Entity\Cylindre", mappedBy="constructeur")
	 */
	private $cylindre;
	
	/**
	 * @ORM\OneToMany(targetEntity="VPM\VehiculeBundle\Entity\Annee", mappedBy="constructeur")
	 */
	private $annee;
	
	/**
	 * @ORM\ManyToMany(targetEntity="VPM\VehiculeBundle\Entity\TypeVehicule", inversedBy="constructeur")
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Constructeur
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
     * Constructor
     */
    public function __construct()
    {
        $this->modele = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cylindre = new \Doctrine\Common\Collections\ArrayCollection();
        $this->modele = new \Doctrine\Common\Collections\ArrayCollection();
        $this->type = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add modele
     *
     * @param \VPM\VehiculeBundle\Entity\Modele $modele
     *
     * @return Constructeur
     */
    public function addModele(\VPM\VehiculeBundle\Entity\Modele $modele)
    {
        $this->modele[] = $modele;

        return $this;
    }

    /**
     * Remove modele
     *
     * @param \VPM\VehiculeBundle\Entity\Modele $modele
     */
    public function removeModele(\VPM\VehiculeBundle\Entity\Modele $modele)
    {
        $this->modele->removeElement($modele);
    }

    /**
     * Get modele
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * Add cylindre
     *
     * @param \VPM\VehiculeBundle\Entity\Cylindre $cylindre
     *
     * @return Constructeur
     */
    public function addCylindre(\VPM\VehiculeBundle\Entity\Cylindre $cylindre)
    {
        $this->cylindre[] = $cylindre;

        return $this;
    }

    /**
     * Remove cylindre
     *
     * @param \VPM\VehiculeBundle\Entity\Cylindre $cylindre
     */
    public function removeCylindre(\VPM\VehiculeBundle\Entity\Cylindre $cylindre)
    {
        $this->cylindre->removeElement($cylindre);
    }

    /**
     * Get cylindre
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCylindre()
    {
        return $this->cylindre;
    }

    /**
     * Add annee
     *
     * @param \VPM\VehiculeBundle\Entity\Annee $annee
     *
     * @return Constructeur
     */
    public function addAnnee(\VPM\VehiculeBundle\Entity\Annee $annee)
    {
        $this->annee[] = $annee;

        return $this;
    }

    /**
     * Remove annee
     *
     * @param \VPM\VehiculeBundle\Entity\Annee $annee
     */
    public function removeAnnee(\VPM\VehiculeBundle\Entity\Annee $annee)
    {
        $this->annee->removeElement($annee);
    }

    /**
     * Get annee
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Add tyoe
     *
     * @param \VPM\VehiculeBundle\Entity\TypeVehicule $tyoe
     *
     * @return Constructeur
     */
    public function addType(\VPM\VehiculeBundle\Entity\TypeVehicule $type)
    {
        $this->type[] = $type;
		$type->addConstructeur($this);
        return $this;
    }

    /**
     * Remove tyoe
     *
     * @param \VPM\VehiculeBundle\Entity\TypeVehicule $tyoe
     */
    public function removeType(\VPM\VehiculeBundle\Entity\TypeVehicule $type)
    {
        $this->type->removeElement($type);
        $type->removeConstructeur($this);
    }

    /**
     * Get tyoe
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getType()
    {
        return $this->type;
    }
}
