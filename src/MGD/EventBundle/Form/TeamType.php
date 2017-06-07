<?php

namespace MGD\EventBundle\Form;

use MGD\EventBundle\Entity\Team;
use MGD\UserBundle\Entity\User;
use MGD\UserBundle\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Team $team */
        $team = $builder->getData();
        $builder
            ->add('name');

        if ($team->getId() !== null) {
            $builder->add('players', EntityType::class, array(
                "class" => 'MGD\UserBundle\Entity\User',
                "multiple" => true,
                "query_builder" => function (UserRepository $userRepository) use ($team) {
                    return $userRepository->getApplicant($team);
                },
                "choice_label" => function (User $user) use ($team) {
                    return $user->getFirstname() . " " . $user->getLastname() . " (" . $user->getGamingUsername($team->getTournament()->getGame()) . ")";
                }
            ));
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MGD\EventBundle\Entity\Team'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mgd_eventbundle_team';
    }


}
