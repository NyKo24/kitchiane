<?php

namespace VPM\ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="VPM\ProduitBundle\Repository\ProduitRepository")
 */
class Produit
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
     * @ORM\Column(name="nomEbay", type="string", length=80, unique=true)
     */
    private $nomEbay;

    /**
     * @var string
     * 
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="referenceSite", type="string", length=255, unique=true)
     */
    private $referenceSite;

    /**
     * @var string
     *
     * @ORM\Column(name="referenceFournisseur", type="string", length=255, nullable=true)
     */
    private $referenceFournisseur;

    /**
     * @var float
     *
     * @ORM\Column(name="prixFournisseurHt", type="float", nullable=true)
     */
    private $prixFournisseurHt;

    /**
     * @var float
     *
     * @ORM\Column(name="prixPublicHt", type="float")
     */
    private $prixPublicHt;

    /**
     * @var string
     *
     * @ORM\Column(name="shortDescription", type="string", length=255)
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
     * @ORM\Column(name="metaKeyword", type="string", length=255, nullable=true)
     */
    private $metaKeyword;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var bool
     *
     * @ORM\Column(name="stock", type="boolean")
     */
    private $stock;

    /**
     * @var float
     *
     * @ORM\Column(name="poids", type="float", nullable=true)
     */
    private $poids;

    /**
     * @var bool
     *
     * @ORM\Column(name="etat", type="boolean")
     */
    private $etat;

    /**
     * @var bool
     *
     * @ORM\Column(name="tousModel", type="boolean")
     */
    private $tousModel;

    /**
     * @var bool
     *
     * @ORM\Column(name="kitChaine", type="boolean")
     */
    private $kitChaine;

    /**
     * @ORM\ManyToMany(targetEntity="VPM\ProduitBundle\Entity\Categorie", mappedBy="produits")
     */
    private $categories;
    
    /**
     * @ORM\OneToMany(targetEntity="VPM\ImageBundle\Entity\Image", cascade={"persist"}, mappedBy="produit", fetch="EAGER")
     */
    private $photos;

    /**
     * @var \DateTime $creation
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $creation;
    
    /**
     * @var \DateTime $updateAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updateAt;
    
    /**
     * @var \DateTime $contentChanged
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"nom", "shortDescription","longDescription"})
     */
    private $contentChanged;
    
    
    /**
     * @var \DateTime $majStock
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"stock"})
     */
    private $majStock;
    
    /**
     * @ORM\ManyToOne(targetEntity="VPM\ProduitBundle\Entity\Marque", inversedBy="produits", fetch="EAGER")
     */
    private $marque;
    
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
     * @return Produit
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
     * Set nomEbay
     *
     * @param string $nomEbay
     *
     * @return Produit
     */
    public function setNomEbay($nomEbay)
    {
        $this->nomEbay = $nomEbay;

        return $this;
    }

    /**
     * Get nomEbay
     *
     * @return string
     */
    public function getNomEbay()
    {
        return $this->nomEbay;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Produit
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
     * Set referenceSite
     *
     * @param string $referenceSite
     *
     * @return Produit
     */
    public function setReferenceSite($referenceSite)
    {
        $this->referenceSite = $referenceSite;

        return $this;
    }

    /**
     * Get referenceSite
     *
     * @return string
     */
    public function getReferenceSite()
    {
        return $this->referenceSite;
    }

    /**
     * Set referenceFournisseur
     *
     * @param string $referenceFournisseur
     *
     * @return Produit
     */
    public function setReferenceFournisseur($referenceFournisseur)
    {
        $this->referenceFournisseur = $referenceFournisseur;

        return $this;
    }

    /**
     * Get referenceFournisseur
     *
     * @return string
     */
    public function getReferenceFournisseur()
    {
        return $this->referenceFournisseur;
    }

    /**
     * Set prixFournisseurHt
     *
     * @param float $prixFournisseurHt
     *
     * @return Produit
     */
    public function setPrixFournisseurHt($prixFournisseurHt)
    {
        $this->prixFournisseurHt = $prixFournisseurHt;

        return $this;
    }

    /**
     * Get prixFournisseurHt
     *
     * @return float
     */
    public function getPrixFournisseurHt()
    {
        return $this->prixFournisseurHt;
    }

    /**
     * Set prixPublicHt
     *
     * @param float $prixPublicHt
     *
     * @return Produit
     */
    public function setPrixPublicHt($prixPublicHt)
    {
        $this->prixPublicHt = $prixPublicHt;

        return $this;
    }

    /**
     * Get prixPublicHt
     *
     * @return float
     */
    public function getPrixPublicHt()
    {
        return $this->prixPublicHt;
    }
    
    public function getMargeHt()
    {
    	return $this->getPrixPublicHt() - $this->getPrixFournisseurHt();
    }

    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     *
     * @return Produit
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
     * @return Produit
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
     * @return Produit
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
     * @return Produit
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
     * @return Produit
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
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Produit
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set stock
     *
     * @param boolean $stock
     *
     * @return Produit
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return bool
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set poids
     *
     * @param float $poids
     *
     * @return Produit
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;

        return $this;
    }

    /**
     * Get poids
     *
     * @return float
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     * Set etat
     *
     * @param boolean $etat
     *
     * @return Produit
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return bool
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set tousModel
     *
     * @param boolean $tousModel
     *
     * @return Produit
     */
    public function setTousModel($tousModel)
    {
        $this->tousModel = $tousModel;

        return $this;
    }

    /**
     * Get tousModel
     *
     * @return bool
     */
    public function getTousModel()
    {
        return $this->tousModel;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add category
     *
     * @param \VPM\ProduitBundle\Entity\Categorie $category
     *
     * @return Produit
     */
    public function addCategory(\VPM\ProduitBundle\Entity\Categorie $category)
    {
        $this->categories[] = $category;
		$category->addProduit($this);
        return $this;
    }

    /**
     * Remove category
     *
     * @param \VPM\ProduitBundle\Entity\Categorie $category
     */
    public function removeCategory(\VPM\ProduitBundle\Entity\Categorie $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

 

    /**
     * Add photo
     *
     * @param \VPM\ImageBundle\Entity\Image $photo
     *
     * @return Produit
     */
    public function addPhoto(\VPM\ImageBundle\Entity\Image $photo)
    {
        $this->photos[] = $photo;
		$photo->setProduit($this);
        return $this;
    }

    /**
     * Remove photo
     *
     * @param \VPM\ImageBundle\Entity\Image $photo
     */
    public function removePhoto(\VPM\ImageBundle\Entity\Image $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set creation
     *
     * @param \DateTime $creation
     *
     * @return Produit
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;

        return $this;
    }

    /**
     * Get creation
     *
     * @return \DateTime
     */
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * Set update
     *
     * @param \DateTime $update
     *
     * @return Produit
     */
    public function setUpdate($update)
    {
        $this->update = $update;

        return $this;
    }

    /**
     * Get update
     *
     * @return \DateTime
     */
    public function getUpdate()
    {
        return $this->update;
    }

    /**
     * Set contentChanged
     *
     * @param \DateTime $contentChanged
     *
     * @return Produit
     */
    public function setContentChanged($contentChanged)
    {
        $this->contentChanged = $contentChanged;

        return $this;
    }

    /**
     * Get contentChanged
     *
     * @return \DateTime
     */
    public function getContentChanged()
    {
        return $this->contentChanged;
    }

    /**
     * Set majStock
     *
     * @param \DateTime $majStock
     *
     * @return Produit
     */
    public function setMajStock($majStock)
    {
        $this->majStock = $majStock;

        return $this;
    }

    /**
     * Get majStock
     *
     * @return \DateTime
     */
    public function getMajStock()
    {
        return $this->majStock;
    }
    
    /**
     * Retourne le tarif TTC du produit
     * 
     * @return number
     */
    public function getPrixTTC()
    {
    	return round($this->getPrixPublicHt() * 1.2,2);
    }
    
    /**
     * Retourne la première image du produit
     * @return mixed
     */
    public function getFirstImage()
    {
    	if (!$this->photos->first())
    	{
    		return new \VPM\ImageBundle\Entity\Image();
    	}
    	return $this->photos->first();
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Produit
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set marque
     *
     * @param \VPM\ProduitBundle\Entity\Marque $marque
     *
     * @return Produit
     */
    public function setMarque(\VPM\ProduitBundle\Entity\Marque $marque = null)
    {
        $this->marque = $marque;
        return $this;
    }

    /**
     * Get marque
     *
     * @return \VPM\ProduitBundle\Entity\Marque
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set kitChaine
     *
     * @param boolean $kitChaine
     *
     * @return Produit
     */
    public function setKitChaine($kitChaine)
    {
        $this->kitChaine = $kitChaine;

        return $this;
    }

    /**
     * Get kitChaine
     *
     * @return boolean
     */
    public function getKitChaine()
    {
        return $this->kitChaine;
    }
}
