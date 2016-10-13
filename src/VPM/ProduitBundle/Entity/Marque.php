<?php

namespace VPM\ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Marque
 *
 * @ORM\Table(name="marque")
 * @ORM\Entity(repositoryClass="VPM\ProduitBundle\Repository\MarqueRepository")
 */
class Marque
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
     * @var string
     *
     * @ORM\Column(name="shortDescription", type="string", length=255, nullable=true)
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="longDescription", type="text", nullable=true)
     */
    private $longDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="metaTitre", type="string", length=55, unique=true)
     */
    private $metaTitre;

    /**
     * @var string
     *
     * @ORM\Column(name="metaDescription", type="string", length=155)
     */
    private $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="metaKeyworkd", type="string", length=255)
     */
    private $metaKeyworkd;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true, unique=true)
     */
    private $website;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;
    
    /**
     * @ORM\OneToMany(targetEntity="VPM\ProduitBundle\Entity\Produit", mappedBy="marque")
     */
    private $produits;
    
    /**
     * @ORM\OneToOne(targetEntity="VPM\ProduitBundle\Entity\LogoMarque", cascade={"all"}, fetch="EAGER")
     */
    private $image;
    
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
     * @return Marque
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
     * Set shortDescription
     *
     * @param string $shortDescription
     *
     * @return Marque
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set longDescription
     *
     * @param string $longDescription
     *
     * @return Marque
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    /**
     * Get longDescription
     *
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * Set metaTitre
     *
     * @param string $metaTitre
     *
     * @return Marque
     */
    public function setMetaTitre($metaTitre)
    {
        $this->metaTitre = $metaTitre;

        return $this;
    }

    /**
     * Get metaTitre
     *
     * @return string
     */
    public function getMetaTitre()
    {
        return $this->metaTitre;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     *
     * @return Marque
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaKeyworkd
     *
     * @param string $metaKeyworkd
     *
     * @return Marque
     */
    public function setMetaKeyworkd($metaKeyworkd)
    {
        $this->metaKeyworkd = $metaKeyworkd;

        return $this;
    }

    /**
     * Get metaKeyworkd
     *
     * @return string
     */
    public function getMetaKeyworkd()
    {
        return $this->metaKeyworkd;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Marque
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Marque
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
     * Constructor
     */
    public function __construct()
    {
        $this->produits = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add produit
     *
     * @param \VPM\ProduitBundle\Entity\Produit $produit
     *
     * @return Marque
     */
    public function addProduit(\VPM\ProduitBundle\Entity\Produit $produit)
    {
        $this->produits[] = $produit;

        return $this;
    }

    /**
     * Remove produit
     *
     * @param \VPM\ProduitBundle\Entity\Produit $produit
     */
    public function removeProduit(\VPM\ProduitBundle\Entity\Produit $produit)
    {
        $this->produits->removeElement($produit);
    }

    /**
     * Get produits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduits()
    {
        return $this->produits;
    }

    /**
     * Set image
     *
     * @param \VPM\ProduitBundle\Entity\LogoMarque $image
     *
     * @return Marque
     */
    public function setImage(\VPM\ProduitBundle\Entity\LogoMarque $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \VPM\ProduitBundle\Entity\LogoMarque
     */
    public function getImage()
    {
        return $this->image;
    }
}
