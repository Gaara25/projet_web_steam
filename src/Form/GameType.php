<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, ['label' => 'title'])
            ->add('image', null, ['label' => 'image'])
            ->add('developer', null, ['label' => 'developer'])
            ->add('releaseDate', null, [
                'widget' => 'single_text',
                'label' => 'release_date'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
