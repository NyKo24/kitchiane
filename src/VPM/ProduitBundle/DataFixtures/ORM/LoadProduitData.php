<?php
namespace VPM\ProduitBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VPM\ProduitBundle\Entity\Produit;
use VPM\ImageBundle\Entity\Image;
use VPM\ProduitBundle\Entity\Marque;
class LoadProduitData implements FixtureInterface{
	
	public function load(ObjectManager $manager)
	{
		for ($i=0; $i < 50 ; $i++) { 
			$produit = new Produit();
		
			$produit->setEtat(true);
			$produit->setLongDescription($i. "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat nonproident, sunt in culpa qui officia deserunt mollit anim id est laborum.");
			$produit->setShortDescription($i. "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo");
			$produit->setMetaDescription("Meta description du produit".$i);
			$produit->setMetaKeyword("produit1,produit2,produit3,".$i);
			$produit->setMetaTitre($i."Kit Chaine Afam 520 Type Mx4 (Couronne Ultra-Light Anti-Boue) Honda Crf250r " );
			$produit->setNom("Kit Chaine Afam 520 " . $i . " Type Mx4 (Couronne Ultra-Light Anti-Boue) Honda Crf250r");
			$produit->setNomEbay("Kit Chaine Afam 520 Type Mx4 Honda Crf250r " . $i);
			$produit->setPoids(1000.0);
			$produit->setPrixFournisseurHt(75.0);
			$produit->setPrixPublicHt(mt_rand(80,200).".".mt_rand(0,99));
			$produit->setQuantite(1);
			$produit->setReferenceFournisseur(mt_rand(1238,9999));
			$produit->setReferenceSite("ref".$i);
			$produit->setStock(true);
			$produit->setTousModel(true);
			$produit->setKitChaine(1);
			
		
			$marque = $manager->find("VPMProduitBundle:Marque", 9);
			
			$categorie = $manager->getRepository("VPMProduitBundle:Categorie")->findOneByNom(array("KIT CHAINE"));
			$marque = $manager->getRepository("VPMProduitBundle:Marque")->findOneByNom(array("AFAM"));
			$produit->setMarque($marque);
			$produit->addCategory($categorie);
			
			$image = new Image();
			$image->setAlt("alternative de l'image");
			$image->setImageName("Image produit");
			$image->setPath("image/produit.jpg");
			$image->setSize("medium");
			$image->setRank(1);
			
			$produit->addPhoto($image);
			$manager->persist($image);
			$manager->persist($produit);
			
		}
		$manager->flush();
	}
	
}