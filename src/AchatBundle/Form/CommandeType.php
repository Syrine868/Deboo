<?php

namespace AchatBundle\Form;

use AchatBundle\Entity\Employee;
use FOS\UserBundle\Model\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('orderdate', DateType::class )
            ->add('transporterchoicedate', DateType::class)
            ->add('orderstate', HiddenType::class,['empty_data' => 'en cours de traitement'])
            ->add('total')
            ->add('transporterstate', HiddenType::class,['empty_data' => 'en cours de traitement'])
            ->add('paymentstate', TextType::class)
            ->add('id', EntityType::class, array(
                 'class'=>\UserBundle\Entity\User::class ,
                'label'=> function (\UserBundle\Entity\User $user)
                {
                    return $user->getId();
                }
            ))
            ->add('idemp', EntityType::class,array(
                'class'=>Employee::class ,
                'choice_label'=> function (Employee $employee)
                {
                    return $employee->getIdemp();
                }
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AchatBundle\Entity\Commande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'achatbundle_commande';
    }


}
