<?php
namespace VPM\TransporteurBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VPM\ProduitBundle\Entity\Categorie;
use VPM\CommandeBundle\Entity\EtatPanier;
use VPM\TransporteurBundle\Entity\Transporteur;

class LoadTransporteurData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		
		$colissimo = new Transporteur();
		$colissimo->setActive(true);
		$colissimo->setDescription("Colissimo Suivi La Poste : Livraison en 48h");
		$colissimo->setNom("Colissimo La Poste");
		
		$manager->persist($colissimo);
		
		$mondialRelay = new Transporteur();
		$mondialRelay->setActive(true);
		$mondialRelay->setDescription("Livraison en point relai par Mondial Relay");
		$mondialRelay->setNom("Mondial Relay");
		
		$manager->persist($mondialRelay);
		$manager->flush();
	}
}