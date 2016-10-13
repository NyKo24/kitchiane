<?php

namespace VPM\CommandeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use VPM\CommandeBundle\Entity\Panier;
use VPM\CommandeBundle\Entity\ProduitPanier;
use VPM\UtilisateurBundle\Entity\Adresse;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use VPM\UtilisateurBundle\Repository\UtilisateurRepository;
use Payplug\Payplug;
use Payplug\Resource\Payment;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment as PayPalPaiement;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use VPM\TransporteurBundle\Entity\Relai;

class PanierController extends Controller
{

	
    public function indexAction()
    {
        return $this->render('VPMCommandeBundle:Default:index.html.twig');
    }
    
    public function montantTotalAction(Request $request)
    {
    	$session = $request->getSession();
    	if (!$session->has("panier"))
    	{
    		$session->set("panier", array());
    		return new Response("0.00");
    	}
    	else
    	{
			$panier =  $session->get("panier");
			if (isset($panier["produit"]))
				return new Response($this->getTotalPanier($panier)["sousTotalTTC"]);
			else
				return new Response("0,00");
    	}
    }
    

    /**
     * Ajouter un produit au panier
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function ajouterProduitAction(Request $request)
    {
    	if ($request->get("quantite") && $request->get("produitId"))
    	{
    		$panier = $request->getSession()->get("panier");
    		$idProduit = $request->get("produitId");
    		$quantite = $request->get("quantite");
			
    		$panier["produit"][$idProduit] = $quantite ;
    		$request->getSession()->set("panier", $panier);

    		$panier["total"] = $this->getTotalPanier($panier);
    		if (!isset($panier["id"]))
    		{
    			$panier["id"] = $this->createPanier();
    		}
	
    		$this->ajoutProduitPanier($idProduit,$quantite,$panier["id"]);
    		$request->getSession()->set("panier", $panier);
    		if ($request->isXmlHttpRequest())
    		{
    			return new JsonResponse($request->getSession()->get("panier"));
    		}
    	}
    }

    /**
     * 
     * @return number
     */
    private function createPanier()
    {
    	$panier = new Panier();
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($panier);
    	$em->flush();
    	return $panier->getId();
    }
    
    /**
     * 
     * @param unknown $idProduit
     * @param unknown $quantite
     * @param unknown $panierId
     */
    private function ajoutProduitPanier($idProduit,$quantite,$panierId)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	$produit = $em->getRepository("VPMProduitBundle:Produit")->find($idProduit);
    	$panier = $em->getRepository('VPMCommandeBundle:Panier')->find($panierId);
    	
    	$produitPanier = new ProduitPanier();
    	
    	$produitPanier->setPanier($panier);
    	$produitPanier->setProduit($produit);
    	$produitPanier->setQuantite($quantite);
    	
    	$em->persist($produitPanier);
    	$em->flush();
    	
    }
    
    /**
     * Afficher le panier
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function afficherAction(Request $request)
    {
    	$panier = $request->getSession()->get("panier",null);
    	$fdp = null;
    	$totalTTC = 0;	
    	$totalHT = 0;
    	$tva = 0;
    	if (isset($panier["produit"]) && count($panier['produit']) > 0)
    	{
    		$ids = array_keys($panier["produit"]);
    		$produits = $this->getDoctrine()->getManager()->getRepository('VPMProduitBundle:Produit')->findById($ids);
    		
    	}
    	else 
    	{
    		$produits = null;
    	}
    	$arrayTotal = $this->getTotalPanier($panier);
    	return $this->render("VPMCommandeBundle:panier:afficher.html.twig",array(
    			"produits" => $produits,
				"totalPanier" => $arrayTotal,
    	));
    }
    
   	/**
   	 * Supprime un produit du panier
   	 * @param unknown $id
   	 * @param Request $request
   	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
   	 */
    public function supprimerAction($id, Request $request)
    {
    	$panier = $request->getSession()->get("panier");
    	if (isset($panier["produit"][$id]))
    	{
    		unset($panier["produit"][$id]);
    		$request->getSession()->set("panier",$panier);
    		$panier = $this->getDoctrine()->getManager()->getRepository('VPMCommandeBundle:Panier')->find($panier['id']);
    		$em = $this->getDoctrine()->getManager();
    		
    		foreach ($panier->getProduitPanier() as $position => $produitPanier)
    		{
    			if ($produitPanier->getProduit()->getId() == $id )
    			{
    				//$panier->removeProduitPanier($produitPanier);
    				$em->remove($produitPanier);
					$em->persist($panier);
    				$em->flush();
    				break;
    			}
    		}
    		$request->getSession()->getFlashBag()->add('success', 'Produit supprimé de votre pannier.');
    	}
    	else
    	{
    		$request->getSession()->getFlashBag()->add('error', "Ce produit n'est pas dans votre panier.");
    	}
    	
    	return $this->redirectToRoute("vpm_panier_afficher");
    }
    
    /**
     * Ajouter une quantité a un produit
     * @param unknown $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function setQuantiteAction($id, Request $request)
    {
    	$quantite = $request->query->get("quantite");
    	$panierSession = $request->getSession()->get("panier");
    	$produitSession = $panierSession["produit"];
    	$produit = null;
    	$panier = $this->getDoctrine()->getManager()->getRepository('VPMCommandeBundle:Panier')->find($panierSession['id']);
    	$idx = null;
    	
    	foreach ($panier->getProduitPanier() as $position => $produitPanier)
    	{
    		if ($produitPanier->getProduit()->getId() == $id)
    		{
    			$produit = $produitPanier->getProduit();
  
    			if (isset($produitSession[$id]))
    			{
    				$produitSession[$id] = $quantite;
    				$produitPanier->setQuantite($quantite);
    				if ($produitSession[$id] <= 0)
    				{
    					unset($produitSession[$id]);
    					$panier->removeProduitPanier($produitPanier);
    					$request->getSession()->getFlashBag()->add('success', 'Le produit '. $produit->getNom() . " a été supprimé de votre panier.");
    				}
    				else
    				{
    					$request->getSession()->getFlashBag()->add('success', "La quantité du produit ". $produit->getNom() . " est maintenant de $quantite.");
    				}
    			
    				$panierSession["produit"]=$produitSession;
    				$request->getSession()->set("panier", $panierSession);
    				$em = $this->getDoctrine()->getManager();
    				$em->persist($panier);
    				$em->persist($produitPanier);
    				$em->flush();
    				
    				return $this->redirectToRoute("vpm_panier_afficher");
    			}
    		}	  		
    	}
 
    	$request->getSession()->getFlashBag()->add('error', "Ce produit n'est pas dans votre panier.");
    	 
    	return $this->redirectToRoute("vpm_panier_afficher");
    }
    
    public function adresseLivraisonAction(Request $request)
    {
    	
    	$repoTypeAdresse = $this->getDoctrine()->getManager()->getRepository("VPMUtilisateurBundle:TypeAdresse");
    	
    	$user = $this->getDoctrine()->getManager()->getRepository("VPMUtilisateurBundle:Utilisateur")->find($this->getUser()->getId());
		$panier = $request->getSession()->get("panier");
		$objPanier = $this->getDoctrine()->getManager()->getRepository("VPMCommandeBundle:Panier")->find($panier["id"]);
		
		$objPanier->setUtilisateur($this->getUser());
		
		$this->getDoctrine()->getManager()->persist($objPanier);
		$this->getDoctrine()->getManager()->flush();
		
		$panier["client"]=$user;
		$adresseLivraison = $user->getAdresseLivraison();
		$panier["adresseLivraison"] = $adresseLivraison;
		if (is_null($adresseLivraison))
		{
			$adresseLivraison = new Adresse();
			$typeLivraison = $repoTypeAdresse->findOneByLibelle("livraison");
			$adresseLivraison->setUtilisateur($user);
			$adresseLivraison->setType($typeLivraison);
			$adresseLivraison->setDefaut(true);
		}
		
		$adresseFacturation = $user->getAdresseFacturation();
		$panier["adresseFacturation"] = $adresseFacturation;
		if (is_null($adresseFacturation))
		{
			$adresseFacturation = new Adresse();
			$repoTypeAdresse = $this->getDoctrine()->getManager()->getRepository("VPMUtilisateurBundle:TypeAdresse");
			$typeFacturation = $repoTypeAdresse->findOneByLibelle("facturation");
			$adresseFacturation->setUtilisateur($user);
			$adresseFacturation->setType($typeFacturation);
			$adresseFacturation->setDefaut(true);
		}
    	
    	$formLivraison = $this->createForm('VPM\UtilisateurBundle\Form\AdresseType', $adresseLivraison);
    	$formLivraison->remove("utilisateur");
    	$formLivraison->remove("type");
    	$formLivraison->remove("defaut");
    	$formLivraison->remove("siret");
    	$formLivraison->remove("tva");
    	
    	$formeFacturation = $this->createForm('VPM\UtilisateurBundle\Form\AdresseType', $adresseFacturation);
    	
    	$formeFacturation->remove("utilisateur");
    	$formeFacturation->remove("type");
    	$formeFacturation->remove("defaut");

    	$request->getSession()->set("panier", $panier);
    	
    	return $this->render("VPMCommandeBundle:Panier:adresseLivraison.html.twig",array(
    			"formLivraison" => $formLivraison->createView(),
    			"formFacturation" => $formeFacturation->createView(),
    			"livraison" => $adresseLivraison,
    			"facturation" => $adresseFacturation,
    	));
    }
    
    public function tabNavAction()
    {
    	return $this->render("VPMCommandeBundle:Panier:tabPanier.html.twig");
    }
    
   public function transporteurAction(Request $request)
   {
   	$panier = $request->getSession()->get("panier");
   	$em = $this->getDoctrine()->getManager();
   		if ($request->isMethod("POST"))
   		{
   			if($request->request->get("transporteur",null) == "mondialRelay")
   			{
   				$tarifTransporteur = $this->get("transporteur_service")->calculeFdp($panier,"mondialRelay");
   				$relai = $em->getRepository("VPMTransporteurBundle:Relai")->findOneByidMondialRelay($request->request->get("relaiId",null));
   				if ($relai == null)
   				{
   					$relai = new Relai();
   					$relai->setIdMondialRelay($request->request->get("relaiId",null));
   					$relai->setNom($request->request->get("relaiNom",null));
   					$relai->setAdresse1($request->request->get("relaiAdresse1",null));
   					$relai->setAdresse2($request->request->get("relaiAdresse2",null));
   					$relai->setCp($request->request->get("relaiCP",null));
   					$relai->setVille($request->request->get("relaiVille",null));
   					$relai->setPays($request->request->get("relaiPays",null));
   					$em->persist($relai);
   					$em->flush();
   				}
   				
   				$transporteur = array(
   						"nom" => "mondialRelay",
   						"infos" => $relai,
   						"tarifTTC" => $tarifTransporteur["ttc"],
   						'tarifHT' => $tarifTransporteur["ht"]
   				);
   			} 
   			elseif ($request->request->get("transporteur",null) == "colissimoLaPoste")
   			{
   				$tarifTransporteur = $this->get("transporteur_service")->calculeFdp($panier,"colissimoLaPoste");
   				$transporteur = array(
   						"nom" => "colissimoLaPoste",
   						"infos" => array(),
   						"tarifTTC" => $tarifTransporteur["ttc"],
   						'tarifHT' => $tarifTransporteur["ht"]
   				);
   			}
   			else 
   			{
   				return $this->redirectToRoute("vpm_panier_transporteur");
   			}
   			$panier["transporteur"]=$transporteur;
   			$request->getSession()->set("panier", $panier);
   			return $this->redirectToRoute("vpm_panier_paiement");
   		}
   		$totalProduitTTC = $this->getTotalPanier($panier)["sousTotalTTC"];
   		
   		$tarifColissimo = $this->get("transporteur_service")->calculeFdp($panier,"colissimoLaPoste")["ttc"];
   		$tarifMondialRelay = $this->get("transporteur_service")->calculeFdp($panier,"mondialRelay")["ttc"];
   		$totalAvecMondialRelay = $totalProduitTTC + $tarifMondialRelay;
   		$totalAvecColissimo = $totalProduitTTC + $tarifColissimo;
   		
   		return $this->render("VPMCommandeBundle:Panier:transporteur.html.twig", array(
   				"totalAvecColissimo" => $totalAvecColissimo,
   				"tarifColissimo" => $tarifColissimo,
   				"tarifMondialRelay" => $tarifMondialRelay,
   				"totalAvecMondialRelay" => $totalAvecMondialRelay,
   		));
   }
   
   public function paiementAction(Request $request)
   {
	   	$panier = $request->getSession()->get("panier",null);
	   	$fdp = null;
	   	$totalTTC = 0;
	   	$totalHT = 0;
	   	$tva = 0;
	   	$transporteur = "";
	   	$produitsPanier = null;
	   	if (isset($panier["produit"]) && count($panier['produit']) > 0)
	   	{
	   		$arrTotal = $this->getTotalPanier($panier);
	   		$produitsPanier = $panier["produit"];
	   		
	   		$ids = array_keys($panier["produit"]);
	   		$produits = $this->getDoctrine()->getManager()->getRepository("VPMProduitBundle:produit")->findById($ids);
	   	}
	   	else
	   	{
	   		$produits = null;
	   	}

	   	$arrTotal = $this->getTotalPanier($panier);
   		return $this->render("VPMCommandeBundle:Panier:paiement.html.twig",array(
   				"produits" => $produits,
   				"fdp" =>  $arrTotal["fdpTTC"],
   				"panier" => $produitsPanier,
   				"totalttc" => $arrTotal["totalTTC"],
   				"totalht" => $arrTotal["totalHT"],
   		));
   }
   
   public function getTotalPanier($panierSession)
   {
	   	$tabId = array();
	   
	   	$sousTotalPanier = $this->get("panier_service")->getSousTotalPanier($panierSession);
	   	
	   	$sousTotalHT = $sousTotalPanier["ht"];
	   	$sousTotalTTC = $sousTotalPanier["ttc"];
	   	if (isset($panierSession["transporteur"]["tarifTTC"]))
	   	{
	   		$fdp["ttc"] = $panierSession["transporteur"]["tarifTTC"];
	   		$fdp["ht"] = $panierSession["transporteur"]["tarifHT"];
	   	}
	   	else
	   	{
	   		$panierSession["sousTotalTTC"]=$sousTotalTTC;
	   		$fdp = $this->get("transporteur_service")->calculeFdp($panierSession,"mondialRelay");
	   	}
	   	
	   	$totalTTC = $sousTotalTTC + $fdp["ttc"];
	   	$totalHT = $sousTotalHT + $fdp["ht"];
	   	
	   	return array(
	   			"sousTotalHT"=>$sousTotalHT,
	   			"sousTotalTTC"=>$sousTotalTTC,
	   			"totalTTC"=>$totalTTC,
	   			"totalHT"=>$totalHT,
	   			"fdpHT"=>$fdp["ht"],
	   			"fdpTTC"=>$fdp["ttc"],
	   			"sousTotalTVA" => $sousTotalTTC - $sousTotalHT,
	   			"totalTVA" => $totalTTC - $totalHT,
	   	);
   }
   	
   public function connexionAction()
   {
   		$securityContext = $this->container->get('security.authorization_checker');
		if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
		{
			return $this->redirectToRoute("vpm_panier_livraison");
		}
   		return $this->render("VPMCommandeBundle:Panier:connexion.html.twig");
   }
   
   /**
    * Génère le paiement PayPlug
    * @param Request $request
    * @return \Symfony\Component\HttpFoundation\RedirectResponse
    */
   public function paiementCBAction(Request $request)
   {
   		$panier = $request->getSession()->get('panier');
   		$client = $this->getDoctrine()->getRepository("VPMUtilisateurBundle:Utilisateur")->find($this->getUser()->getId());
   		$totalTTC = $this->getTotalPanier($panier)["totalTTC"];
		$totalTTC = number_format($totalTTC,2);
   		Payplug::setSecretKey($this->getParameter("payplugToken"));
   		$paiement = Payment::create(array(
   				'amount'            => $totalTTC*100,
   				'currency'          => 'EUR',
   				'customer'          => array(
   						'email'             => $client->getEmail(),
   						'first_name'        => $client->getPrenom(),
   						'last_name'         => $client->getNom()
   				),
   				'hosted_payment'    => array(
   						'return_url'        => $this->getParameter("baseUrl").'/panier/paiement-cb-return/paiement',
   						'cancel_url'        => $this->getParameter("baseUrl").'/panier/paiement-cb-return/cancel'
   				),
   				'metadata'          => array(
   						'client'    => $client->getId(),
   						'panier'	=> $panier["id"]
   				)
   		));
   		$url = $paiement->hosted_payment->payment_url;
   		$id = $paiement->id;
   		
   		$panier["id_paiement"] = $id;
   		$request->getSession()->set("panier",$panier);
   		return $this->redirect($url);
   		
   }
   
   /**
    * Génère le paiement PayPal
    * @param Request $request
    * @return \Symfony\Component\HttpFoundation\Response|\Symfony\Component\HttpFoundation\RedirectResponse
    */
   public function paiementPayPalAction(Request $request)
   {
 	
   	
	   	$panier = $request->getSession()->get("panier");
	   	$produitPanier = $panier["produit"];
	   	
	   	// ### Payer
	   	// A resource representing a Payer that funds a payment
	   	// For paypal account payments, set payment method
	   	// to 'paypal'.
	   	$payer = new Payer();
	   	$payer->setPaymentMethod("paypal");
	   	
	   	$itemList = new ItemList();
	   	$itemArray = array();
	   	
	   	$repoProduit = $this->getDoctrine()->getManager()->getRepository("VPMProduitBundle:Produit");
	   	$totalHt = 0; 
	   	$totalTtc = 0;
	   	foreach ($produitPanier as $idProduit => $quantite)
	   	{
	   		$produit = $repoProduit->find($idProduit);
	   		$item = new Item();
	   		$item->setName($produit->getNom())
	   			->setCurrency("EUR")
	   			->setQuantity($quantite)
	   			->setSku($produit->getReferenceSite())
	   			->setPrice($produit->getPrixPublicHt())
	   			->setTax($produit->getPrixTTC() - $produit->getPrixPublicHt());
	   		
	   		$totalHt+= $produit->getPrixPublicHt() * $quantite;
	   		$totalTtc = $produit->getPrixTTC() * $quantite;
	   		$itemArray[] = $item;
	   	}
	   	
	   	$itemList->setItems($itemArray);
	   	
	   	// ### Additional payment details
	   	// Use this optional field to set additional
	   	// payment information such as tax, shipping
	   	// charges etc.
	   	$details = new Details();
	   	$details->setShipping(3.90)
	   	->setTax($totalTtc - $totalHt)
	   	->setSubtotal($totalHt);
	   	
	   	// ### Amount
	   	// Lets you specify a payment amount.
	   	// You can also specify additional details
	   	// such as shipping, tax.
	   	$amount = new Amount();
	   	$amount->setCurrency("EUR")
	   	->setTotal($totalTtc + 3.90)
	   	->setDetails($details);
	   	
	   	// ### Transaction
	   	// A transaction defines the contract of a
	   	// payment - what is the payment for and who
	   	// is fulfilling it.
	   	$transaction = new Transaction();
	   	$transaction->setAmount($amount)
	   	->setItemList($itemList)
	   	->setDescription("Payment description")
	   	->setInvoiceNumber(uniqid());
	   	// ### Redirect urls
	   	// Set the urls that the buyer must be redirected to after
	   	// payment approval/ cancellation.
	   	$baseUrl = "http://localhost/vpm-huile/app_dev.php";
	   	$redirectUrls = new RedirectUrls();
	   	$redirectUrls->setReturnUrl("$baseUrl/panier/paypal-execute/true")
	   	->setCancelUrl("$baseUrl/panier/paypal-execute/false");
	   	// ### Payment
	   	// A Payment Resource; create one using
	   	// the above types and intent set to 'sale'
	   	$payment = new PayPalPaiement();
	   	$payment->setIntent("sale")
	   	->setPayer($payer)
	   	->setRedirectUrls($redirectUrls)
	   	->setTransactions(array($transaction));

	   	// ### Create Payment
	   	// Create a payment by calling the 'create' method
	   	// passing it a valid apiContext.
	   	// (See bootstrap.php for more on `ApiContext`)
	   	// The return object contains the state and the
	   	// url to which the buyer must be redirected to
	   	// for payment approval
	   	try {
	   		$payment->create($this->getApiContext($this->getParameter("payPalClientId"),$this->getParameter("payPalClientSecret")));
	   	} catch (Exception $ex) {

	   		return new Response($ex->getMessage());
	   	}
	   	// ### Get redirect url
	   	// The API response provides the url that you must redirect
	   	// the buyer to. Retrieve the url from the $payment->getApprovalLink()
	   	// method
	   	$approvalUrl = $payment->getApprovalLink();
	   
	   	return new RedirectResponse($approvalUrl);
   }
   
   /**
    * Helper method for getting an APIContext for all calls
    * @param string $clientId Client ID
    * @param string $clientSecret Client Secret
    * @return PayPal\Rest\ApiContext
    */
   private function getApiContext($clientId, $clientSecret)
   {
   
   	// #### SDK configuration
   	// Register the sdk_config.ini file in current directory
   	// as the configuration source.
   	/*
   	if(!defined("PP_CONFIG_PATH")) {
   	define("PP_CONFIG_PATH", __DIR__);
   	}
   	*/
   
   
   	// ### Api context
   	// Use an ApiContext object to authenticate
   	// API calls. The clientId and clientSecret for the
   	// OAuthTokenCredential class can be retrieved from
   	// developer.paypal.com
   
   	$apiContext = new ApiContext(
   			new OAuthTokenCredential(
   					$clientId,
   					$clientSecret
   					)
   			);
   
   	// Comment this line out and uncomment the PP_CONFIG_PATH
   	// 'define' block if you want to use static file
   	// based configuration
   
   	$apiContext->setConfig(
   			array(
   					'mode' => 'sandbox',
   					'log.LogEnabled' => false,
   					'log.FileName' => '../PayPal.log',
   					'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
   					'cache.enabled' => true,
   					// 'http.CURLOPT_CONNECTTIMEOUT' => 30
   					// 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
   					//'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
   			)
   			);
   
   	// Partner Attribution Id
   	// Use this header if you are a PayPal partner. Specify a unique BN Code to receive revenue attribution.
   	// To learn more or to request a BN Code, contact your Partner Manager or visit the PayPal Partner Portal
   	// $apiContext->addRequestHeader('PayPal-Partner-Attribution-Id', '123123123');
   
   	return $apiContext;
   }
    
   /**
    * Traitement le paiement lors du retour de PayPal
    * @param boolean $etat
    * @param Request $request
    * @return \Symfony\Component\HttpFoundation\Response
    */
   public function executePayPalAction($etat, Request $request)
   {
   		return new Response(var_dump($etat));
   }
   
   /**
    * Traite le paiement lors du retour de PayPlug
    * @param string $etat
    * @param Request $request
    */
   public function returnPaiementCBAction($etat, Request $request)
   {
   	$commande = null;
   	$em = $this->getDoctrine()->getManager();
   	$panier = $request->getSession()->get("panier",null);
   		if ($etat == "paiement")
   		{

   			if (empty($panier))
   			{
   				return $this->redirectToRoute("vpm_home_homepage");
   			}
   			
   			$idPaiement = $panier["id_paiement"];
   			
   			Payplug::setSecretKey($this->getParameter("payplugToken"));
   			$paiement = \Payplug\Payment::retrieve($idPaiement);
   			
   			if ($paiement->is_paid)
   			{
   				
   				$objCommande = $this->get("commande_service")->createCommandeByPanier($panier);
   				$objCommande->setMethodePaiement($this->get("methode_paiement_service")->getPayPlug());
				if ($panier["transporteur"]["infos"] != null)
				{
					$objCommande->setRelai($em->getRepository("VPMTransporteurBundle:Relai")->find($panier["transporteur"]["infos"]->getId()));
				}
   				
				$objCommande = $this->get("facture_service")->makeFacture($objCommande);
				
				$this->getDoctrine()->getManager()->persist($objCommande);
				$this->getDoctrine()->getManager()->flush();
				$this->get("commande_service")->envoyerConfirmationCommande($objCommande);
				if ($objCommande)
				{
					$commande = true;
					$request->getSession()->remove("panier");
					return $this->render("VPMCommandeBundle:Panier:valider.html.twig",array(
							"commande" => $objCommande,
							"paiement" => "carte bancaire",
					));
				}
   			}
   			else
   			{
   				$errorCode = $paiement->failure->code;
   				$commande = false;
   				return $this->render("VPMCommandeBundle:Panier:echec_cb.html.twig",array(
   						"raison" => $this->getTradErrorPayPlug($errorCode),
   						"totalPanier"=>$this->getTotalPanier($panier),
   				));
   			}
   		}
   		else if ($etat == "cancel")
   		{
   			return $this->render("VPMCommandeBundle:Panier:paiement_annule.html.twig",array(
   					"totalPanier"=>$this->getTotalPanier($panier),
   			));
   		}
   }
   
   /**
    * Retourne la traduction en français des erreurs renvoyées par PayPlug en cas d'échech du paiement
    * @param string $code
    * @return string
    */
   public function getTradErrorPayPlug($code)
   {
   		switch ($code)
   		{
   			case "processing_error":
   				return "erreur durant le traitement de votre paiement";
   			break;
   			case "card_declined":
   				return "votre carte a été rejetée";
   			break;
   			case "insufficient_funds":
   				return "vous ne disposez pas suffisament de fond pour payer cette commande";
   			break;
   			case "3ds_declined":
   				return "la vérification 3D secure a écouché";
   			break;
   			case "incorrect_number":
   				return "votre numéro de carte est incorrect";
   			break;
   			case "fraud_suspected":
   				return "le paiement a été rejeté car une tentative de fraude a été détectée";
   			break;
   			case "aborted":
   				return "le paiement a été annulé";
   			default:
   				return "une erreur inconnue s'est produite durant le paiement";
   		}
   }


}



