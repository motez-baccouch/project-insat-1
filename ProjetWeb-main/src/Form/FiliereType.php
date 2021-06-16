<?php

namespace App\Form;

use App\Entity\Filiere;
use App\Entity\Niveau;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiliereType extends AbstractType
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choixNiveaux = $this->manager->getRepository(Niveau::class)->getNiveauxArray();

        $builder
            ->add('filiere')
            ->add('ordre')
            ->add('niveaux', ChoiceType::class, [
                'choices' => $choixNiveaux,
                'expanded' => true,
                'multiple' => true,
                'getter' => function(Filiere $filiere, FormInterface $form): array{
                    return $filiere->getSelectedNiveaux();
                },
                'setter' => function(Filiere $filiere, array $niveaux, FormInterface $form){
                    $filiere->setSelectedNiveaux($niveaux, $this->manager);
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Filiere::class,
        ]);
    }
}
