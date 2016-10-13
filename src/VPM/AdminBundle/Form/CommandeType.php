<?php

namespace VPM\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference')
            ->add('factureId')
            ->add('factureToken')
            ->add('tarifHtTransporteur')
            ->add('suivi')
            ->add('creation', 'datetime')
            ->add('updateAt', 'datetime')
            ->add('paiementId')
            ->add('etat')
            ->add('transporteur')
            ->add('adresseLivraison')
            ->add('methodePaiement')
            ->add('adresseFacturation')
            ->add('panier')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VPM\CommandeBundle\Entity\Commande'
        ));
    }
}
