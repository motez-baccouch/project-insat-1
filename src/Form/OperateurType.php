<?php

namespace App\Form;

use App\Entity\Operateur;
use App\Service\UserManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('nom')
            ->add('prenom')
            ->add('roles', ChoiceType::class,[
                'choices' => [
                    UserManager::ROLE_ADMIN => UserManager::ROLE_ADMIN,
                    UserManager::ROLE_EDITEUR_BASE => UserManager::ROLE_EDITEUR_BASE,
                    UserManager::ROLE_EDITEUR_SITE => UserManager::ROLE_EDITEUR_SITE,
                    UserManager::ROLE_VALIDATEUR => UserManager::ROLE_VALIDATEUR,
                    UserManager::ROLE_SCOLARITE => UserManager::ROLE_SCOLARITE,
                ],
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('password')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operateur::class,
        ]);
    }
}
