<?php


namespace App\Form;

use App\Entity\Filiere;
use App\Entity\Matiere;
use App\Entity\Niveau;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ScolariteType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('semester', ChoiceType::class, [
                'choices'  => [
                    'semester1' => 1,
                    'semester2' => 2,

                ],
            ])
            ->add('filiere',EntityType::class, [
                'class' => Filiere::class,
                'choice_label' => 'filiere',
            ])
            ->add('niveau',EntityType::class, [
                'class' => Niveau::class,
                'choice_label' => 'niveau',
            ])
            ->add('matiere',EntityType::class, [
                'class' => Matiere::class,
                'choice_label' => 'nom',
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ])
        ;
    }

   /* public function configureOptions(OptionsResolver $resolver)
    {
        $scolarite=[];
        $resolver->setDefaults([
            'data_class' => $scolarite,
        ]);
    }*/

}