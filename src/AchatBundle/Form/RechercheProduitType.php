<?php


namespace AchatBundle\Form;


use AchatBundle\Entity\Category;
use AchatBundle\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class RechercheProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoryid', EntityType::class ,
                           array(
                               'label'=> 'Categorie',
                               'class'=>Category::class,
                                  'choice_label'=>function (Category $category)
                                  {return $category->getCategoryname();}
                               ))
            ->add('recherche', SubmitType::class);
    }
}