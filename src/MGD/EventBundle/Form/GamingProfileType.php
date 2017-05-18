<?php

namespace MGD\EventBundle\Form;

use MGD\EventBundle\Entity\Game;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GamingProfileType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('game', EntityType::class, array(
                "class" => 'MGD\EventBundle\Entity\Game',
                "choice_label"  => function(Game $game) {
                    return $game->getName();
                }
            ))
            ->add("username");

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MGD\EventBundle\Entity\GamingProfile'
        ));
    }
}
