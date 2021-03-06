<?php

namespace VPM\ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="VPM\ProduitBundle\Repository\CategorieRepository")
 */
class Categorie
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
     * @ORM\Column(name="idBihr", type="string", length=20, nullable=true, unique=true)
     */
    private $idBihr;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=140)
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
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(name="slug", type="string", length=140, unique=true)
     * 
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="metaTitre", type="string", length=140, unique=true)
     */
    private $metaTitre;

    /**
     * @var string
     *
     * @ORM\Column(name="metaDescription", type="string", length=255, unique=false)
     */
    private $metaDescription;
    
    /**
     * @var string
     *
     * @ORM\Column(name="metaKeyword", type="string", length=255, unique=false)
     */
    private $metaKeyword;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", unique=false)
     */
    private $active;
    
    /**
     * Creates a parent / child relationship on this entity.
     *
     * @ORM\ManyToOne(targetEntity="VPM\ProduitBundle\Entity\Categorie",inversedBy="id")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="set null")
     */
    private $parent = null;
    
    /**
     * @ORM\OneToMany(targetEntity="Categorie", mappedBy="parent", orphanRemoval=true)
     */
    private $enfant;
    
    /**
     * @ORM\ManyToMany(targetEntity="VPM\ProduitBundle\Entity\Produit", inversedBy="categories")
     */
    private $produits;
    
    public function __construct()
    {
    	$this->enfant = new ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Categorie
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
     * @return Categorie
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
     * @return Categorie
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Categorie
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
     * Set metaTitre
     *
     * @param string $metaTitre
     *
     * @return Categorie
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
     * @return Categorie
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
     * Set metaKeyword
     *
     * @param string $metaKeyword
     *
     * @return Categorie
     */
    public function setMetaKeyword($metaKeyword)
    {
        $this->metaKeyword = $metaKeyword;

        return $this;
    }

    /**
     * Get metaKeyword
     *
     * @return string
     */
    public function getMetaKeyword()
    {
        return $this->metaKeyword;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Categorie
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set parent
     *
     * @param \VPM\Produit\Entity\Categorie $parent
     *
     * @return Categorie
     */
    public function setParent(\VPM\ProduitBundle\Entity\Categorie $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \VPM\Produit\Entity\Categorie
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add enfant
     *
     * @param \VPM\ProduitBundle\Entity\Categorie $enfant
     *
     * @return Categorie
     */
    public function addEnfant(\VPM\ProduitBundle\Entity\Categorie $enfant)
    {
        $this->enfant[] = $enfant;
		$enfant->setParent($this);
        return $this;
    }

    /**
     * Remove enfant
     *
     * @param \VPM\ProduitBundle\Entity\Categorie $enfant
     */
    public function removeEnfant(\VPM\ProduitBundle\Entity\Categorie $enfant)
    {
        $this->enfant->removeElement($enfant);
    }

    /**
     * Get enfant
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnfant()
    {
        return $this->enfant;
    }

    /**
     * Add produit
     *
     * @param \VPM\ProduitBundle\Entity\Produit $produit
     *
     * @return Categorie
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
     * Set idBihr
     *
     * @param string $idBihr
     *
     * @return Categorie
     */
    public function setIdBihr($idBihr)
    {
        $this->idBihr = $idBihr;

        return $this;
    }

    /**
     * Get idBihr
     *
     * @return string
     */
    public function getIdBihr()
    {
        return $this->idBihr;
    }
}
