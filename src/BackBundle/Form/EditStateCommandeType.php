<?php


namespace BackBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class EditStateCommandeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('transporterChoiceDate', DateType::class, array(
            'label'=>'Choix transporteur'
        ))
            ->add('orderState', ChoiceType::class , array(
                'label'=>'Etat commande',
                "choices"=>[
                    'en attente de confirmation' => 'en attente de confirmation',
                    'en cours de traitement'=> 'en cours de traitement',
                    'livrée'=> 'livrée']
            ) )
            ->add('transporterState', ChoiceType::class , array(
                'label'=>'Etat transporteur',
                "choices"=> [
                    'affecté'=> 'affecté',
                    'non affecté'=>'non affecté',
                ]
            ))
            ->add('valider', SubmitType::class, array(
                'label'=>'Sauvergarder les modifications'
            ));

    }
}