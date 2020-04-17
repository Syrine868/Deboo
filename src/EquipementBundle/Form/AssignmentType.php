<?php

namespace EquipementBundle\Form;

use EquipementBundle\Entity\Employee;
use EquipementBundle\Entity\Equipment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssignmentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('datep',DateType::class, [
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd'])
            ->add('dater',DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'])
            ->add('state',ChoiceType::class, [
                'choices'=>[
                    'Etat'=> [
                        'Trés bien'=> 'tres_bien',
                        'bien'=> 'bien',
                        'Assez bien'=> 'assez_bien',
                    ]
                ]
            ])
            ->add('employee',EntityType::class , [
                'class'=> Employee::class,
                'choice_label'=> function (Employee $employee)
                {
                    return $employee->getLastnameemp();
                }
            ])
            ->add('equipment',EntityType::class , [

                'class'=> Equipment::class,

                'choice_label'=> function (Equipment $equipment)
                {

                 return    $equipment->getEquipmentname();
                }
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EquipementBundle\Entity\Assignment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'equipementbundle_assignment';
    }


}
