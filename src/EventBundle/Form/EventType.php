<?php

namespace EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('title',TextType::class,["label" => "Titulo"])
          ->add('startDate',DateTimeType::class,["label" => "Inicio",'widget' => 'single_text','attr' => ['placeholder' => 'dd/M/yyyy HH:mm']])
          ->add('endDate',DateTimeType::class,["label" => "Fin",'widget' => 'single_text','attr' => ['placeholder' => 'dd/M/yyyy HH:mm']])
          ->add('places', IntegerType::class, ["label" => "Nº Plazas",'attr' => ['min' => 1]])
          ->add('description',TextareaType::class,["label" => "Descripción de la actividad"])
          ->add('price',MoneyType::class,["label" => "Precio","attr" => ["value" => 0]])
          ->add('showPlaces',CheckboxType::class,["label" => "Muestra el numero de plazas restantes" ])
          ->add('images', VichImageType::class, [
            'attr' => ['id' => 'imageinput','hidden' => 'hidden'],
            'label' => "Foto de la actividad",
            'required' => false,
            'allow_delete' => true,
            'download_link' => true,
          ])
          ->add('guardar', SubmitType::class, array('attr' => array('class' => 'btn btn-primary')))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EventBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'eventbundle_event';
    }


}
