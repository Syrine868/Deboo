<?php

namespace AchatBundle\Form;

use AchatBundle\Entity\Commande;
use AchatBundle\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderLineType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('quantity', NumberType::class)
            ->add('idorder', EntityType::class , array(
                'class'=> Commande::class,
                'label'=> function (Commande $commande)
                {
                    return $commande->getIdorder();
                }
            ))
            ->add('idproduct', EntityType::class , array(
                'class'=> Product::class,
                'label'=> function (Product $product)
                {
                    return $product->getIdproduct();
                }
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AchatBundle\Entity\OrderLine'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'achatbundle_orderline';
    }


}
