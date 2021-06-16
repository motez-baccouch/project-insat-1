<?php

namespace App\Form;

use App\Entity\Departement;
use App\Entity\Enseignant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnseignantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('departement',EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionner un Département'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Enseignant::class,
        ]);
    }
}
