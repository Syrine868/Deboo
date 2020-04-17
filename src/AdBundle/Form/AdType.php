<?php


namespace AdBundle\Form;

use Symfony\Component\Form\AbstractType;
use AdBundle\Entity\Sponsor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends  AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {



        $builder->add('titre')
            ->add('description')
            ->add('dateDebut')
            ->add('endDate')
            ->add('imageFile', FileType::class)
            ->add('sponsor_name',EntityType::class, [
                'class' => Sponsor::class,
                'choice_label' => function ($Sponsor) {
                    return $Sponsor->getName();
                }
            ]);

    }

    /**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\AdBundle\Entity\Ad'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adbundle_ad';
    }


}