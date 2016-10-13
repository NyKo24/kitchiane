<?php

namespace VPM\VehiculeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Annee
 *
 * @ORM\Table(name="annee")
 * @ORM\Entity(repositoryClass="VPM\VehiculeBundle\Repository\AnneeRepository")
 */
class Annee
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
     * @var int
     *
     * @ORM\Column(name="annee", type="smallint")
     */
    private $annee;
    
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="VPM\VehiculeBundle\Entity\Constructeur")
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
     * Set annee
     *
     * @param integer $annee
     *
     * @return Annee
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return int
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set constructeur
     *
     * @param \VPM\VehiculeBundle\Entity\Constructeur $constructeur
     *
     * @return Annee
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
