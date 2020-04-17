<?php

namespace ClaimBundle\Form;

use ClaimBundle\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ClaimType extends AbstractType
{/**
 * {@inheritdoc}
 */
    public function buildForm1(FormBuilderInterface $formC, array $options)
    {

        $formC->add('answer', TextareaType::class, [
            'attr' => ['class' => 'tinymce'],
        ])->add('status', ChoiceType::class, [
        'choices' => [
            new Status(Status::Pendng),
            new Status(Status::Solved),
            new Status(Status::Closed),
        ],
        'choice_label' => 'displayName',
    ]);

    }/**
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $formClaim, array $options)
    {

        $formClaim->add('message', TextareaType::class, [
            'attr' => ['class' => 'tinymce'],
        ]);



    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClaimBundle\Entity\Claim'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'claimbundle_claim';
    }


}
