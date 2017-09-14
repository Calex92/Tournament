<?php

namespace MGD\NewsBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class NewsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class,
                    array(
                        "label" => "Titre"
                    )
                )
                ->add('visible', CheckboxType::class,
                    array(
                        "attr"      => array(
                            "data-toggle"  => "toggle",
                            "data-on"   => "Actif",
                            "data-off"  => "Inactif"),
                        "label"     => " ",
                        "required"  => false
                    )
                )
                ->add('publicationDate', DateType::class,
                    array(
                        "widget"    => "single_text",
                        "attr"      => array("class"    => "js-datepicker"),
                        "html5"     => false,
                        "format"    => "dd-MM-yyyy",
                        "label"     => "Date de publication"
                    )
                )
                ->add('body', CKEditorType::class,
                    array(
                        "config"    => array(
                            'uiColor' => '#ffffff'
                        ),
                        "label" => "Corps du texte"
                    )
                )
                ->add('coverFile', VichImageType::class,
                    array (
                        "label"     => "Image de couverture",
                        'required' => false,
                        'allow_delete' => true
                    )
                );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MGD\NewsBundle\Entity\News'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mgd_newsbundle_news';
    }


}
