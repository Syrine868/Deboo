<?php

namespace EmployeBundle\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EmployeeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastnameemp', TextType::class)
            ->add('firstnameemp',TextType::class)
            ->add('age')
            ->add('phone')
            ->add('salary')
            ->add('emailaddress')
            ->add('fonction',ChoiceType::class, [
                'choices'  => [
                    'DG' => 'DG',
                    'DGA' => 'DGA',
                    'PDG' => 'PDG',
                    'Transporteur' => 'Transporteur',
                    'Chef dep Marketing' => 'Chef dep Marketing',
                    'Responsable Stock' => 'Responsable Stock',
                    'Ouvrier' => 'Ouvrier',
                    'Chef ..' => 'Chef ..',
                    '...' => '...'],

        ])
            ->add('pic',FileType::class, array('data_class' => null));

            //->add('ajouter' , SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EmployeBundle\Entity\Employee'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'employebundle_employee';
    }


}
