<?php

namespace VPM\UtilisateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdresseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('societe')
            ->add('siret')
            ->add('tva')
            ->add('ligne1')
            ->add('ligne2')
            ->add('complement')
            ->add('defaut')
            ->add('cp')
            ->add('ville')
            ->add('utilisateur',UtilisateurType::class)
            ->add('type',TypeAdresseType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VPM\UtilisateurBundle\Entity\Adresse'
        ));
    }
}
