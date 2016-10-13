<?php

namespace VPM\VehiculeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cylindre
 *
 * @ORM\Table(name="cylindre")
 * @ORM\Entity(repositoryClass="VPM\VehiculeBundle\Repository\CylindreRepository")
 */
class Cylindre
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
     * @ORM\Column(name="taille", type="string", length=10, unique=false)
     */
    private $taille;

    /**
     * @ORM\ManyToOne(targetEntity="VPM\VehiculeBundle\Entity\Constructeur")
     */
    private $constructeur;
    
    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="VPM\VehiculeBundle\Entity\Modele", mappedBy="cylindre")
     */
    private $modele;
    
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
     * Set taille
     *
     * @param string $taille
     *
     * @return Cylindre
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * Get taille
     *
     * @return string
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * Set constructeur
     *
     * @param \VPM\VehiculeBundle\Entity\Constructeur $constructeur
     *
     * @return Cylindre
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modele = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add modele
     *
     * @param \VPM\VehiculeBundle\Entity\Modele $modele
     *
     * @return Cylindre
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
}
