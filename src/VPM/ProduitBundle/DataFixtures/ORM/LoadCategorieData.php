<?php
namespace VPM\ProduitBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VPM\ProduitBundle\Entity\Categorie;

class LoadCategorieData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$categorie = new Categorie();
		$categorie->setActive(true);
		$categorie->setNom("KIT CHAINE");
		$categorie->setShortDescription("Tout les kit chaines");
		$categorie->setLongDescription("Tout les kit chaines de moto 2T et 4T");
		$categorie->setMetaTitre("Kit chaine Meta Titre");
		$categorie->setMetaDescription("Kit chaine Meta description");
		$categorie->setMetaKeyword("keyword1,keyword2,keyword3");
		$categorie->setIdBihr("04.000");
		
		
		
		$categorie2 = new Categorie();
		$categorie2->setActive(true);
		$categorie2->setNom("sub kit chaine");
		$categorie2->setShortDescription("sub kit chaine");
		$categorie2->setLongDescription("sub kit chaine");
		$categorie2->setMetaTitre("sub kit chaine 2T Meta Titre");
		$categorie2->setMetaDescription("sub kit chaine Meta description");
		$categorie2->setMetaKeyword("keyword1,keyword2,keyword3");
		$categorie2->setIdBihr("03.478");
		
		$categorie->addEnfant($categorie2);
		
		$manager->persist($categorie);
		$manager->persist($categorie2);
		$manager->flush();
	}
}