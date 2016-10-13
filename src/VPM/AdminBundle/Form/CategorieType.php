<?php

namespace VPM\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategorieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idBihr')
            ->add('nom')
            ->add('shortDescription')
            ->add('longDescription')
            ->add('slug',TextType::class,array(
            		"required" => false
            ))
            ->add('metaTitre')
            ->add('metaDescription')
            ->add('metaKeyword')
            ->add('active')
            ->add("racine",CheckboxType::class,array(
            		"mapped" => false,
            		"required" => false,
            ))
            ->add('parent', EntityType::class, array(
            		"class" => "VPMProduitBundle:Categorie",
            		'choice_label' => 'nom',
            		'multiple'     => false,
            		"expanded" => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VPM\ProduitBundle\Entity\Categorie'
        ));
    }
}
