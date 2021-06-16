<?php

namespace App\Form;

use App\Entity\HistorySelection;
use App\Utilities\FormHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistorySelectionType extends AbstractType
{

    private $manager;

    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $options['data'] ;
        $anneeChoices = FormHelper::getAnneesScolaire($data->getTmpEtudiant(), $this->manager);
        $builder
            ->add('annee',ChoiceType::class, [
                'label' => 'Année',
                'choices' => $anneeChoices,
                'placeholder' => 'Sélectionner une année',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HistorySelection::class,
        ]);
    }
}
