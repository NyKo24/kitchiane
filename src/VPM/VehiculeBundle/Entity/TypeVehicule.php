<?php

namespace VPM\VehiculeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeVehicule
 *
 * @ORM\Table(name="type_vehicule")
 * @ORM\Entity(repositoryClass="VPM\VehiculeBundle\Repository\TypeVehiculeRepository")
 */
class TypeVehicule
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
     * @ORM\Column(name="nom", type="string", length=30, unique=true)
     */
    private $nom;
    
    /**
     * @ORM\ManyToMany(targetEntity="VPM\VehiculeBundle\Entity\Constructeur", mappedBy="type")
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
     * @return TypeVehicule
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
        $this->constructeur = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add constructeur
     *
     * @param \VPM\VehiculeBundle\Entity\Constructeur $constructeur
     *
     * @return TypeVehicule
     */
    public function addConstructeur(\VPM\VehiculeBundle\Entity\Constructeur $constructeur)
    {
        $this->constructeur[] = $constructeur;

        return $this;
    }

    /**
     * Remove constructeur
     *
     * @param \VPM\VehiculeBundle\Entity\Constructeur $constructeur
     */
    public function removeConstructeur(\VPM\VehiculeBundle\Entity\Constructeur $constructeur)
    {
        $this->constructeur->removeElement($constructeur);
    }

    /**
     * Get constructeur
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConstructeur()
    {
        return $this->constructeur;
    }
}
