<?php

namespace App\Form;

use App\Entity\Actualite;
use App\Entity\User;
use App\Utilities\FormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilePhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        FormHelper::addImgFileInput($builder, 'image', 'Image');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
