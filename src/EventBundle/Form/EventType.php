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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('title',TextType::class,["label" => "NOMBRE DE LA ACTIVIDAD", 'attr' => [
          'class' => 'form-control', 'maxlength' => 80]])
          ->add('startDate', DateType::class,
              ['widget' => 'single_text','format' => 'yyyy-MM-dd',
              'attr' => [
              'class' => 'form-control',
              'data-provide' => 'datepicker',
              'data-date-format' => 'yyy-mm-dd']])
          ->add('startTime', null, ['widget' => 'single_text',
          'attr' => [
          'class' => 'form-control']])
          ->add('endTime', null, ['widget' => 'single_text',
          'attr' => [
          'class' => 'form-control']])
          ->add('endDate', DateType::class,
              ['widget' => 'single_text','format' => 'yyyy-MM-dd',
              'attr' => [
              'class' => 'form-control',
              'data-provide' => 'datepicker',
              'data-date-format' => 'yyy-mm-dd']])
          ->add('places', IntegerType::class, ["label" => "Nº DE PLAZAS", 'attr' => ['style' => 'width: 100px', 'min' => 1, 'class' => 'form-control']])
          ->add('description',TextareaType::class,["label" => "DESCRIPCIÓN", 'attr' => ['style' => 'height: 150px',  'maxlength'=> "3500", 'class' => 'form-control']])
          ->add('price',MoneyType::class,["label" => "PRECIO","attr" => ['style' => 'width: 100px', "value" => 0, 'class' => 'form-control']])
          ->add('showPlaces',null,["label" => "Muestra el numero de plazas restantes", 'required' => false, 'attr' => [
          'class' => 'custom-control-input']])
          ->add('images', VichImageType::class, [
            'attr' => ['id' => 'imageinput','hidden' => 'hidden'],
            'label' => "FOTO DE LA ACTIVIDAD",
            'required' => false,
            'allow_delete' => true,
            'download_link' => true,
          ])
          ->add('id_orchard', HiddenType::class, array('mapped' => false))
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
