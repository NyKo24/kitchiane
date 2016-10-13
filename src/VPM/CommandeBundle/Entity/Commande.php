<?php

namespace VPM\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VPM\UtilisateurBundle\Entity\Adresse;
use Gedmo\Mapping\Annotation as Gedmo;
use VPM\TransporteurBundle\Entity\Relai;
/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="VPM\CommandeBundle\Repository\CommandeRepository")
 */
class Commande
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
     * @ORM\Column(name="reference", type="string", length=50, unique=true)
     */
    private $reference;
    
    /**
     * @var string
     *
     * @ORM\Column(name="factureId", type="string", length=50, unique=false, nullable=true)
     */
    private $factureId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="factureToken", type="string", length=150, unique=true, nullable=true)
     */
    private $factureToken;

    /**
     * @ORM\ManyToOne(targetEntity="VPM\CommandeBundle\Entity\EtatCommande")
     * @ORM\JoinColumn(nullable=true)
     */
    private $etat;
    
    /**
     * @ORM\ManyToOne(targetEntity="VPM\TransporteurBundle\Entity\Transporteur")
     * @ORM\JoinColumn(nullable=true)
     */
    private $transporteur;
    
    /**
     * @var float
     *
     * @ORM\Column(name="tarifHtTransporteur", type="float", unique=false, nullable=true)
     */
    private $tarifHtTransporteur;
    
    /**
     * @var float
     *
     * @ORM\Column(name="tarifReelHtTransporteur", type="float", unique=false, nullable=true)
     */
    private $tarifReelHtTransporteur;
    
    /**
     * @var string
     *
     * @ORM\Column(name="suivi", type="string", length=150, unique=true, nullable=true)
     */
    private $suivi;
    
    /**
     * @var Adresse
     *
     * @ORM\ManyToOne(targetEntity="VPM\UtilisateurBundle\Entity\Adresse")
     */
    private $adresseLivraison;
    
    /**
     * @var MethodePaiement
     *
     * @ORM\ManyToOne(targetEntity="VPM\CommandeBundle\Entity\MethodePaiement")
     */
    private $methodePaiement;
    
    /**
     * @var Adresse
     *
     * @ORM\ManyToOne(targetEntity="VPM\UtilisateurBundle\Entity\Adresse")
     */
    private $adresseFacturation;
    
    /**
     * @var Panier
     *
     * @ORM\OneToOne(targetEntity="VPM\CommandeBundle\Entity\Panier", mappedBy="commande" )
     */
    private $panier;
    
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
     * @var string
     *
     * @ORM\Column(name="paiementId", type="string", length=250, unique=true, nullable=true)
     */
    private $paiementId;
    
    /**
     * @var Relai
     *
     * @ORM\ManyToOne(targetEntity="VPM\TransporteurBundle\Entity\Relai")
     */
    private $relai;
    
    /**
     * @var float
     *
     * @ORM\Column(name="poids", type="float", unique=false, nullable=true)
     */
    private $poids;
    
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
     * Set reference
     *
     * @param string $reference
     *
     * @return Commande
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set etat
     *
     * @param \VPM\CommandeBundle\Entity\EtatCommande $etat
     *
     * @return Commande
     */
    public function setEtat(\VPM\CommandeBundle\Entity\EtatCommande $etat = null)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return \VPM\CommandeBundle\Entity\EtatCommande
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set suivi
     *
     * @param string $suivi
     *
     * @return Commande
     */
    public function setSuivi($suivi)
    {
        $this->suivi = $suivi;

        return $this;
    }

    /**
     * Get suivi
     *
     * @return string
     */
    public function getSuivi()
    {
        return $this->suivi;
    }

    /**
     * Set transporteur
     *
     * @param \VPM\TransporteurBundle\Entity\Transporteur $transporteur
     *
     * @return Commande
     */
    public function setTransporteur(\VPM\TransporteurBundle\Entity\Transporteur $transporteur = null)
    {
        $this->transporteur = $transporteur;

        return $this;
    }

    /**
     * Get transporteur
     *
     * @return \VPM\TransporteurBundle\Entity\Transporteur
     */
    public function getTransporteur()
    {
        return $this->transporteur;
    }

    /**
     * Set adresseLivraison
     *
     * @param string $adresseLivraison
     *
     * @return Commande
     */
    public function setAdresseLivraison(\VPM\UtilisateurBundle\Entity\Adresse $adresseLivraison)
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    /**
     * Get adresseLivraison
     *
     * @return string
     */
    public function getAdresseLivraison()
    {
        return $this->adresseLivraison;
    }

    /**
     * Set adresseFacturation
     *
     * @param string $adresseFacturation
     *
     * @return Commande
     */
    public function setAdresseFacturation(\VPM\UtilisateurBundle\Entity\Adresse $adresseFacturation)
    {
        $this->adresseFacturation = $adresseFacturation;

        return $this;
    }

    /**
     * Get adresseFacturation
     *
     * @return string
     */
    public function getAdresseFacturation()
    {
        return $this->adresseFacturation;
    }

    /**
     * Set panier
     *
     * @param string $panier
     *
     * @return Commande
     */
    public function setPanier($panier)
    {
        $this->panier = $panier;

        return $this;
    }

    /**
     * Get panier
     *
     * @return string
     */
    public function getPanier()
    {
        return $this->panier;
    }

    /**
     * Set factureId
     *
     * @param string $factureId
     *
     * @return Commande
     */
    public function setFactureId($factureId)
    {
        $this->factureId = $factureId;

        return $this;
    }

    /**
     * Get factureId
     *
     * @return string
     */
    public function getFactureId()
    {
        return $this->factureId;
    }

    /**
     * Set factureToken
     *
     * @param string $factureToken
     *
     * @return Commande
     */
    public function setFactureToken($factureToken)
    {
        $this->factureToken = $factureToken;

        return $this;
    }

    /**
     * Get factureToken
     *
     * @return string
     */
    public function getFactureToken()
    {
        return $this->factureToken;
    }

    /**
     * Set tarifHtTransporteur
     *
     * @param float $tarifHtTransporteur
     *
     * @return Commande
     */
    public function setTarifHtTransporteur($tarifHtTransporteur)
    {
        $this->tarifHtTransporteur = $tarifHtTransporteur;

        return $this;
    }

    /**
     * Get tarifTtcTransporteur
     *
     * @return float
     */
    public function getTarifTtcTransporteur()
    {
    	return $this->getTarifHtTransporteur() * 1.2;
    }
    
    /**
     * Get tarifHtTransporteur
     *
     * @return float
     */
    public function getTarifHtTransporteur()
    {
        return $this->tarifHtTransporteur;
    }

    /**
     * Set methodePaiement
     *
     * @param \VPM\CommandeBundle\Entity\MethodePaiement $methodePaiement
     *
     * @return Commande
     */
    public function setMethodePaiement(\VPM\CommandeBundle\Entity\MethodePaiement $methodePaiement = null)
    {
        $this->methodePaiement = $methodePaiement;

        return $this;
    }

    /**
     * Get methodePaiement
     *
     * @return \VPM\CommandeBundle\Entity\MethodePaiement
     */
    public function getMethodePaiement()
    {
        return $this->methodePaiement;
    }

    /**
     * Set creation
     *
     * @param \DateTime $creation
     *
     * @return Commande
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
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Commande
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
     * Montant total TTC de la commande
     * @return number
     */
    public function getTotalCommandeTtc()
    {
    	return $this->getPanier()->getTotalPanierTtc() + $this->getTarifTtcTransporteur();
    }
    
    /**
     * Montant total HT de la commande
     * @return number
     */
   	public function getTotalCommandeHt()
   	{
   		return $this->getPanier()->getTotalPanierHt() + $this->getTarifHtTransporteur();
   	}
    
   	/**
   	 * Montant total de la TVA de la commande
   	 * @return number
   	 */
    public function getTvaTotal()
    {
    	return ($this->getTotalCommandeTtc() - $this->getTotalCommandeHt());
    }
    
    /**
     * Marge brut HT de la commande
     */
    public function getMargeHt()
    {
    	return $this->getTotalCommandeHt() - $this->getPanier()->getTotalHtTarifFournisseur();
    }

    /**
     * Set paiementId
     *
     * @param string $paiementId
     *
     * @return Commande
     */
    public function setPaiementId($paiementId)
    {
        $this->paiementId = $paiementId;

        return $this;
    }

    /**
     * Get paiementId
     *
     * @return string
     */
    public function getPaiementId()
    {
        return $this->paiementId;
    }

    /**
     * Set relai
     *
     * @param \VPM\TransportBundle\Entity\Relai $relai
     *
     * @return Commande
     */
    public function setRelai(\VPM\TransporteurBundle\Entity\Relai $relai = null)
    {
        $this->relai = $relai;

        return $this;
    }

    /**
     * Get relai
     *
     * @return \VPM\TransportBundle\Entity\Relai
     */
    public function getRelai()
    {
        return $this->relai;
    }

    /**
     * Set tarifReelHtTransporteur
     *
     * @param float $tarifReelHtTransporteur
     *
     * @return Commande
     */
    public function setTarifReelHtTransporteur($tarifReelHtTransporteur)
    {
        $this->tarifReelHtTransporteur = $tarifReelHtTransporteur;

        return $this;
    }

    /**
     * Get tarifReelHtTransporteur
     *
     * @return float
     */
    public function getTarifReelHtTransporteur()
    {
        return $this->tarifReelHtTransporteur;
    }

    /**
     * Set poids
     *
     * @param float $poids
     *
     * @return Commande
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
}
