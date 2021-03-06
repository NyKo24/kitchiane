<?php

namespace VPM\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier")
 * @ORM\Entity(repositoryClass="VPM\CommandeBundle\Repository\PanierRepository")
 */
class Panier
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
     * @ORM\Column(name="ip", type="string", length=15, nullable=true)
     */
    private $ip;

    /**
     * @ORM\ManyToOne(targetEntity="VPM\UtilisateurBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(nullable=true)
     */
	private $utilisateur;

	/**
	 * @ORM\OneToMany(targetEntity="VPM\CommandeBundle\Entity\ProduitPanier", mappedBy="panier", fetch="EAGER")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private $produitPanier;
	
	/**
	 * @var Commande
	 * 
	 * @ORM\OneToOne(targetEntity="VPM\CommandeBundle\Entity\Commande", inversedBy="panier")
	 */
	private $commande;
	
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
     * Set ip
     *
     * @param string $ip
     *
     * @return Panier
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }


    /**
     * Set utilisateur
     *
     * @param \VPM\UtilisateurBundle\Entity\Utilisateur $utilisateur
     *
     * @return Panier
     */
    public function setUtilisateur(\VPM\UtilisateurBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \VPM\UtilisateurBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }


    /**
     * Add produitPanier
     *
     * @param \VPM\CommandeBundle\Entity\ProduitPanier $produitPanier
     *
     * @return Panier
     */
    public function addProduitPanier(\VPM\CommandeBundle\Entity\ProduitPanier $produitPanier)
    {
        $this->produitPanier[] = $produitPanier;

        return $this;
    }

    /**
     * Remove produitPanier
     *
     * @param \VPM\CommandeBundle\Entity\ProduitPanier $produitPanier
     */
    public function removeProduitPanier(\VPM\CommandeBundle\Entity\ProduitPanier $produitPanier)
    {
        $this->produitPanier->removeElement($produitPanier);
    }

    /**
     * Get produitPanier
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduitPanier()
    {
        return $this->produitPanier;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->produitPanier = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set commande
     *
     * @param string $commande
     *
     * @return Panier
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return string
     */
    public function getCommande()
    {
        return $this->commande;
    }
    
    public function getTotalPanierTtc()
    {
    	$totalTTC = 0.0;
    	foreach ($this->getProduitPanier() as $produitPanier)
    	{
    		$totalTTC+= $produitPanier->getProduit()->getPrixTTC() * $produitPanier->getQuantite();
    	}
    	return $totalTTC;
    }
    
    public function getTotalPanierHt()
    {
    	$totalHt = 0.0;
    	foreach ($this->getProduitPanier() as $produitPanier)
    	{
    		$totalHt+= $produitPanier->getProduit()->getPrixPublicHt() * $produitPanier->getQuantite();
    	}
    	return $totalHt;
    }
    
    /**
     * Montant fournisseur des articles en HT
     * @return number
     */
    public function getTotalHtTarifFournisseur()
    {
    	$tarifFournisseurHt = 0.0;
    	foreach ($this->getProduitPanier() as $produitPanier)
    	{
    		$tarifFournisseurHt+= $produitPanier->getProduit()->getPrixFournisseurHt() * $produitPanier->getQuantite();
    	}
    	return $tarifFournisseurHt;
    }
}
