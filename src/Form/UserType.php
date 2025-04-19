<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, ['label' => 'username'])
            ->add('email', null, ['label' => 'email'])
            ->add('avatar', null, [
                'label' => 'avatar',
                'attr' => ['readonly' => true,],
            ])
            ->add('avatarFile', VichImageType::class, [
                'required' => false,
                'label' => 'avatarFile',
                'download_uri' => false,
                'image_uri' => false,
                'allow_delete' => false,
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
                'label' => 'created_at'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
