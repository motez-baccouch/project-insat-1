<?php

namespace App\Form;

use App\Entity\Actualite;
use App\Utilities\FormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActualiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('date', DateType::class,[
                'widget'=>'single_text',
            ])
            ->add('description',TextareaType::class,[
                'attr' => [
                    'rows' => 3,
                ],
            ]);
            FormHelper::addImgFileInput($builder, 'image', 'Image');
            FormHelper::addPdfFileInput($builder, 'document', 'Document lié');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Actualite::class,
        ]);
    }
}
