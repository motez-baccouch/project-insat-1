<?php

namespace App\Form;

use App\Entity\FicheNotes;
use App\Entity\Filiere;
use App\Entity\MatiereNiveauFiliere;
use App\Entity\Niveau;
use App\Utilities\FormHelper;
use App\Utilities\Tools;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FicheNotesType extends AbstractType
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choixMatieres = [];
        if($fiche = $options['data'] ?? null){
            if( $matiere = $fiche->getMatiere() ?? null)
            $choixMatieres = FormHelper::getMatieres($matiere->getSemestre(), $matiere->getFiliere(), $matiere->getNiveau(), $this->manager);
        }

        $builder->add('tmpSemestre', ChoiceType::class, [
            'choices' => FormHelper::getSemestres(),
            'label' => 'Semestre',
            'expanded' => true,
            'attr' => [
                'id' => "semestre",
            ],
            ])
            ->add('tmpFiliereNiveau', ChoiceType::class, [
                'choices' => FormHelper::getGroupedInputFiliereNiveau($this->manager),
                'label' => 'Niveau',
                'placeholder' => 'Sélectionner un niveau',
                'attr' => [
                    'id' => "niveau",
                ],
            ])
            ->add('matiere',ChoiceType::class, [
                'choices' => $choixMatieres,
                'placeholder' => 'Sélectionner une matiére',
                'getter' => function (FicheNotes $ficheNotes, FormInterface $form): int {
                return 0;
                },
                'setter' => function (FicheNotes $ficheNotes, $matiere, FormInterface $form) {
                },
            ]);
        FormHelper::addPdfFileInput($builder, 'doc', 'Fiche des Notes')

            ->add('commentaire', TextareaType::class, [
                'attr' => [
                    'rows' => 2,
                ],
                'required' => false,
            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FicheNotes::class,
        ]);
    }

}
