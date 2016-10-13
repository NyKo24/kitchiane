<?php

namespace VPM\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProduitPanier
 *
 * @ORM\Table(name="produit_panier")
 * @ORM\Entity(repositoryClass="VPM\CommandeBundle\Repository\ProduitPanierRepository")
 */
class ProduitPanier
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
     * @ORM\Column(name="quantite", type="smallint")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity="VPM\ProduitBundle\Entity\Produit", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
	private $produit;
	
	/**
	 * @ORM\ManyToOne(targetEntity="VPM\CommandeBundle\Entity\Panier", inversedBy="produitPanier")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $panier;
	
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
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return ProduitPanier
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
     * Set produit
     *
     * @param \VPM\CommandeBundle\Entity\Produit $produit
     *
     * @return ProduitPanier
     */
    public function setProduit(\VPM\ProduitBundle\Entity\Produit $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \VPM\CommandeBundle\Entity\Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set panier
     *
     * @param \VPM\CommandeBundle\Entity\Panier $panier
     *
     * @return ProduitPanier
     */
    public function setPanier(\VPM\CommandeBundle\Entity\Panier $panier)
    {
        $this->panier = $panier;
		$panier->addProduitPanier($this);
        return $this;
    }

    /**
     * Get panier
     *
     * @return \VPM\CommandeBundle\Entity\Panier
     */
    public function getPanier()
    {
        return $this->panier;
    }
}
