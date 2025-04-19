<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\GameStat;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameStatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hoursPlayed', null, ['label' => 'hours_played'])
            ->add('lastPlayed', null, [
                'widget' => 'single_text',
                'label' => 'last_played'
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'label' => 'user'
            ])
            ->add('game', EntityType::class, [
                'class' => Game::class,
                'choice_label' => 'title',
                'label' => 'game'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GameStat::class,
        ]);
    }
}
