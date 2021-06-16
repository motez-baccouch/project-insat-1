<?php

namespace App\Form;


use App\Entity\Filiere;
use App\Entity\Matiere;
use App\Entity\MatiereNiveauFiliere;
use App\Entity\Niveau;
use App\Utilities\FormHelper;
use App\Utilities\Tools;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatiereNiveauFiliereType extends AbstractType
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choixMatieres = $this->manager->getRepository(Matiere::class)->getMatiereArray();

        $builder
            ->add('matiere',ChoiceType::class, [
                    'choices' => $choixMatieres,
                    'placeholder' => 'Sélectionner une matiére',
                    'getter' => function (MatiereNiveauFiliere $matiereNiveauFiliere, FormInterface $form): int {
                        $matiere = $matiereNiveauFiliere->getMatiere();
                        return !empty($matiere) ? $matiere->getId() : 0;
                    },
                    'setter' => function (MatiereNiveauFiliere $matiereNiveauFiliere, $matiere, FormInterface $form) {
                        $matiereNiveauFiliere->setMatiere($this->manager->getRepository(Matiere::class)->find($matiere));
                    },
                ]);
        //$this->addFiliereNiveau1($builder);
        $this->addFiliereNiveau2($builder)
        ->add('semestre',ChoiceType::class, [
            'choices' => FormHelper::getSemestres(),
            'expanded' => true,
            'getter' => function (MatiereNiveauFiliere $matiereNiveauFiliere, FormInterface $form): int {
                return $matiereNiveauFiliere->getSemestre() ?? 0;
            },
            'setter' => function (MatiereNiveauFiliere $matiereNiveauFiliere, $semestre, FormInterface $form) {
                $matiereNiveauFiliere->setSemestre($semestre);
            },
        ])
        ->add('coefficient')
        ->add('ds',CheckboxType::class, [
            'label' => 'DS',
            'required' => false
        ])
        ->add('tp',CheckboxType::class, [
            'label' => 'TP',
            'required' => false
        ])
        ->add('examen',CheckboxType::class, [
            'label' => 'Examen',
            'required' => false
        ])
        ->add('ordre');
    }

    private function addFiliereNiveau1(FormBuilderInterface $builder): FormBuilderInterface{
        $choixFilieres = $this->manager->getRepository(Filiere::class)->getFiliereArray();
        $choixNiveaux = $this->manager->getRepository(Niveau::class)->getNiveauxArray();

        return $builder->add('filiere', ChoiceType::class, [
            'choices' => $choixFilieres,
            'placeholder' => 'Sélectionner une filiére',
            'getter' => function (MatiereNiveauFiliere $matiereNiveauFiliere, FormInterface $form): int {
                $filiere = $matiereNiveauFiliere->getFiliere();
                return !empty($filiere) ? $filiere->getId() : 0;
            },
            'setter' => function (MatiereNiveauFiliere $matiereNiveauFiliere, $filiere, FormInterface $form) {
                $matiereNiveauFiliere->setFiliere($this->manager->getRepository(Filiere::class)->find($filiere));
            },
        ])
            ->add('niveau',ChoiceType::class, [
                'choices' => $choixNiveaux,
                'placeholder' => 'Sélectionner un niveau',
                'getter' => function (MatiereNiveauFiliere $matiereNiveauFiliere, FormInterface $form): int {
                    $niveau = $matiereNiveauFiliere->getNiveau();
                    return !empty($niveau) ? $niveau->getId() : 0;
                },
                'setter' => function (MatiereNiveauFiliere $matiereNiveauFiliere, $niveau, FormInterface $form) {
                    $matiereNiveauFiliere->setNiveau($this->manager->getRepository(Niveau::class)->find($niveau));
                },
            ]);
    }

    private function addFiliereNiveau2(FormBuilderInterface $builder): FormBuilderInterface{

        return $builder->add('filiere_niveau', ChoiceType::class, [
            'choices' => FormHelper::getGroupedInputFiliereNiveau($this->manager),
            'placeholder' => 'Sélectionner un niveau',
            'getter' => function (MatiereNiveauFiliere $matiereNiveauFiliere, FormInterface $form): int {
                $filiere = $matiereNiveauFiliere->getFiliere();
                $niveau = $matiereNiveauFiliere->getNiveau();
                return !empty($filiere) && !empty($niveau)? Tools::toExId($filiere->getId(), $niveau->getId()) : 0;
            },
            'setter' => function (MatiereNiveauFiliere $matiereNiveauFiliere, $exId, FormInterface $form) {
                $ids = Tools::splitExId($exId);
                $matiereNiveauFiliere->setFiliere($this->manager->getRepository(Filiere::class)->find($ids["masterId"]));
                $matiereNiveauFiliere->setNiveau($this->manager->getRepository(Niveau::class)->find($ids["slaveId"]));
            },
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MatiereNiveauFiliere::class,
        ]);
    }
}
