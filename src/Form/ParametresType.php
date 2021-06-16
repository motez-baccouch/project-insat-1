<?php

namespace App\Form;

use App\Entity\Parametres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParametresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse', TextareaType::class, [
                'attr' => ['rows' => 3],
            ])
            ->add('tel')
            ->add('fax')
            ->add('email')
            ->add('anneScolaireCourante')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Parametres::class,
        ]);
    }
}
