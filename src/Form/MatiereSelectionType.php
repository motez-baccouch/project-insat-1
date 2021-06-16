<?php

namespace App\Form;

use App\Entity\MatiereSelection;
use App\Utilities\FormHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatiereSelectionType extends AbstractType
{

    private $manager;

    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $options['data'] ;
        $etudiant = $data->getTmpEtudiant();
        $matiereChoices = FormHelper::getGroupedInputSemestreMatiere($etudiant->getFiliere(), $etudiant->getNiveau(), $this->manager);
        $builder
            ->add('matiere',ChoiceType::class, [
                'label' => 'Matière',
                'choices' => $matiereChoices,
                'placeholder' => 'Sélectionner une matière',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MatiereSelection::class,
        ]);
    }
}
