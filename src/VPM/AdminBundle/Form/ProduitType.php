<?php

namespace VPM\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use VPM\AdminBundle\Form\ImageType;


class ProduitType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('nomEbay')
            ->add('slug')
            ->add('referenceSite')
            ->add('referenceFournisseur')
            ->add('prixFournisseurHt')
            ->add('prixPublicHt')
            ->add('shortDescription')
            ->add('longDescription')
            ->add('metaTitre')
            ->add('metaDescription')
            ->add('metaKeyword')
            ->add('quantite')
            ->add('stock')
            ->add('poids')
            ->add('etat')
            ->add('tousModel')
            ->add('categorie',EntityType::class, array(
            		"mapped" => false,
            		"class" => "VPMProduitBundle:Categorie",
            		'choice_label' => 'nom',
            		'multiple'     => false,
            		"expanded" => false,
            ))
            ->add('marque',EntityType::class,array(
            		"class" => "VPMProduitBundle:Marque",
            		"choice_label" => "nom",
            		'multiple'     => false,
            		"expanded" => false,
            ))
            ->add("image",ImageType::class,array(
            		"mapped" => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VPM\ProduitBundle\Entity\Produit'
        ));
    }
}
