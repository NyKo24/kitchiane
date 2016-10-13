<?php
namespace VPM\CommandeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VPM\CommandeBundle\Entity\MethodePaiement;


class LoadMethodePaiementData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$methodePaiement = new MethodePaiement();
		$methodePaiement->setLibelle("PayPlug");
		
		$manager->persist($methodePaiement);
		
		$methodePaiement = new MethodePaiement();
		$methodePaiement->setLibelle("PayPal");
		
		$manager->persist($methodePaiement);
		
		$manager->flush();
	}
}