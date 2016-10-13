<?php
namespace VPM\ProduitBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use VPM\ProduitBundle\Entity\Marque;
use VPM\ProduitBundle\Entity\LogoMarque;

class LoadMarqueData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$marque = new Marque();
		$marque->setNom("AFAM");
		
		$marque->setLongDescription("Très grande marque de kit chaine qui est très très connue");
		$marque->setShortDescription("Kit chaine mais pas que.");
		
		$marque->setMetaDescription("Meta désription marque AFAM");
		$marque->setMetaKeyworkd("keyword1,keyword2,keyword3");
		$marque->setWebsite("http://www.afam.com");
		$marque->setMetaTitre("AFAM Meta Title");
		
		$logo = new LogoMarque();
		$logo->setAlt("Logo Afam");
		$logo->setSize("normal");
		$logo->setPath("image/marque/afam.jpg");
		$marque->setImage($logo);
		$manager->persist($marque);
		$manager->flush();
	}
}