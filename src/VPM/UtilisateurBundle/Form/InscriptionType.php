<?php
namespace VPM\UtilisateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class InscriptionType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('prenom');
		$builder->add("nom");
		$builder->add("dateNaissance", BirthdayType::class, array(
				"label"=>"Date de naissance", 
				'format' => 'dd-MM-yyyy',
				"widget" => "single_text"
		));
	}

	public function getParent()
	{
		return 'FOS\UserBundle\Form\Type\RegistrationFormType';

		// Or for Symfony < 2.8
		// return 'fos_user_registration';
	}

	public function getBlockPrefix()
	{
		return 'app_user_registration';
	}

}