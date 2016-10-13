<?php
namespace VPM\VehiculeBundleBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VPM\VehiculeBundle\Entity\Modele;
use VPM\VehiculeBundle\Entity\Constructeur;
use VPM\VehiculeBundle\Entity\Annee;
use VPM\VehiculeBundle\Entity\Cylindre;
use VPM\VehiculeBundle\Entity\TypeVehicule;

class LoadModeleData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$file = file_get_contents(__DIR__."/trendsAndModelAndYearMoto.json");
		$file = json_decode($file,true);
		
		$objType = new TypeVehicule();
		$objType->setNom("moto");
		foreach ($file as $marque)
		{
			$objConstructeur = $manager->getRepository("VPMVehiculeBundle:Constructeur")->findOneByNom(trim($marque["name"]));
			if (is_null($objConstructeur)) // si la marque n'existe pas on la créer
			{
				$objConstructeur = new Constructeur();
				$objConstructeur->setNom($marque["name"]);
				$objConstructeur->addType($objType);
				$manager->persist($objConstructeur);
			}
			else
			{
				if (!$objConstructeur->getType()->contains($objType))
				{
					$objConstructeur->addType($objType);
				}
			}
			
			
			// pour chaque cylindre
			foreach ($marque["cylindre"] as $cylindres => $modeles)
			{
				$objCylindre = $manager->getRepository("VPMVehiculeBundle:Cylindre")->findOneBy(
						array("taille"=>$cylindres,"constructeur" => $objConstructeur ));
				if (is_null($objCylindre)) // si la marque n'existe pas on la créer
				{
					$objCylindre = new Cylindre();
					$objCylindre->setTaille($cylindres);
					$objCylindre->setConstructeur($objConstructeur);
					$manager->persist($objCylindre);
				}
				
				// pour chque modèle 
				foreach ($modeles as $keyModele =>  $modele)
				{
					foreach ($modele as $annee)
					{
						$objAnnee = $manager->getRepository("VPMVehiculeBundle:Annee")->findOneBy(
								array("annee"=>$annee, "constructeur"=>$objConstructeur));
						if (is_null($objAnnee))
						{
							$objAnnee = new Annee();
							$objAnnee->setAnnee($annee);
							$objAnnee->setConstructeur($objConstructeur);
							$manager->persist($objAnnee);
						}
						
						$objModele = new Modele();
						$objModele->setCylindre($objCylindre);
						$objModele->setNom($keyModele);
						$objModele->setAnnee($objAnnee);
						$objModele->setType($objType);
						$objModele->setConstructeur($objConstructeur);
						$manager->persist($objModele);
					}
					
				}
				
				
			}
			
			$manager->flush();
		}
		
		
	}
}