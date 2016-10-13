<?php
namespace VPM\CommandeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VPM\CommandeBundle\Entity\EtatCommande;

class LoadEtatCommandeData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$etatCommande = new EtatCommande();
		$etatCommande->setLibelle("En préparation");
		
		$manager->persist($etatCommande);
		
		$etatCommande = new EtatCommande();
		$etatCommande->setLibelle("Expédiée");
		
		$manager->persist($etatCommande);
		$manager->flush();
	}
}