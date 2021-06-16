<?php

namespace App\Form;

use App\Entity\EmploiDuTemps;
use App\Entity\Filiere;
use App\Entity\MatiereNiveauFiliere;
use App\Service\AppDataManager;
use App\Utilities\FormHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmploiDuTempsType extends AbstractType
{
    private $manager;
    private $appDataManager;

    public function __construct(EntityManagerInterface $manager, AppDataManager $appDataManager)
    {
        $this->manager = $manager;
        $this->appDataManager = $appDataManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choixFilieres = $this->manager->getRepository(Filiere::class)->getFiliereArray();

        $builder
            ->add('anneeScolaire', HiddenType::class,[
                'data' => $this->appDataManager->getParametres()->getAnneScolaireCourante(),
            ])
            ->add('filiere', ChoiceType::class, [
                'choices' => $choixFilieres,
                'placeholder' => 'Sélectionner une filiére',
                'getter' => function (EmploiDuTemps $emploi, FormInterface $form): int {
                    $filiere = $emploi->getFiliere();
                    return !empty($filiere) ? $filiere->getId() : 0;
                },
                'setter' => function (EmploiDuTemps $emploi, $filiere, FormInterface $form) {
                    $emploi->setFiliere($this->manager->getRepository(Filiere::class)->find($filiere));
                },
            ])
            ->add('semestre',ChoiceType::class, [
                'choices' => [
                    'semestre 1' => '1',
                    'semestre 2' => '2'
                ],
                'expanded' => true,
                'getter' => function (EmploiDuTemps $emploi, FormInterface $form): int {
                    return $emploi->getSemestre() ?? 0;
                },
                'setter' => function (EmploiDuTemps $emploi, $semestre, FormInterface $form) {
                    $emploi->setSemestre($semestre);
                },
            ]);

        FormHelper::addPdfFileInput($builder, 'document', 'Document');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmploiDuTemps::class,
        ]);
    }
}
