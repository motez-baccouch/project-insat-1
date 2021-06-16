<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Filiere;
use App\Entity\Niveau;
use phpDocumentor\Reflection\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')

            ->add('password',)
            ->add('nom')
            ->add('prenom')
            ->add('numInscription')
            ->add('filiere',EntityType::class, [
                'class' => Filiere::class,
                'choice_label' => 'filiere',
            ])
            ->add('niveau',EntityType::class, [
                'class' => Niveau::class,
                'choice_label' => 'niveau',


            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
