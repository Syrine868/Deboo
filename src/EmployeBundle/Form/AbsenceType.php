<?php

namespace EmployeBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use EmployeBundle\Entity\Employee;

class AbsenceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date',DateType::class, [
            'attr' => ['class' => 'bootstrap-daterangepicker']

        ])
           /*  ->add('idemp',EntityType::class , array('class'=>'EmployeBundle\Entity\Employee',
                      'choice_label'=>'firstnameemp',
                      'expanded'=>false,
                      'multiple'=>false,
                      ))*/
            ->add('Add', SubmitType::class , ['attr' => ['class' => 'btn btn-theme btn-sm ']]);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EmployeBundle\Entity\Absence'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'employebundle_absence';
    }


}
