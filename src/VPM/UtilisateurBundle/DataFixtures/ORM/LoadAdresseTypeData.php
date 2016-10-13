<?php
namespace VPM\UtilisateurBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VPM\ProduitBundle\Entity\Categorie;
use VPM\CommandeBundle\Entity\EtatPanier;
use VPM\UtilisateurBundle\Entity\TypeAdresse;

class LoadAdresseTypeData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$typeAdresse = new TypeAdresse();
		$typeAdresse->setLibelle("livraison");
		
		$manager->persist($typeAdresse);
		
		$typeAdresse = new TypeAdresse();
		$typeAdresse->setLibelle("facturation");
		
		$manager->persist($typeAdresse);
		$manager->flush();
	}
}