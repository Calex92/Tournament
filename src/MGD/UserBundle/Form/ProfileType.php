<?php
/**
 * Created by PhpStorm.
 * User: acastelain
 * Date: 18/05/2017
 * Time: 11:35
 */

namespace MGD\UserBundle\Form;


use MGD\EventBundle\Form\GamingProfileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove("email")
            ->remove("username")
            ->add("firstname")
            ->add("lastname")
            ->add("gamingProfiles", CollectionType::class, array(
                "required"  => false,
                "entry_type"    => GamingProfileType::class,
                "allow_add"     => true,
                "allow_delete"  => true,
                "entry_options" => array(
                    "attr"  => array("class"    => "gaming-profile")
                )
            ));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
}
