<?php
namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Util\LegacyFormHelper;

class UserType extends BaseRegistrationFormType {

  private $class;

  /**
  * @param string $class The User class name
  */
  public function __construct($class)
  {
    $this->class = $class;
  }

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
        ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => false, 'attr' => array('placeholder' => 'user.register.type.email')))
        ->add('username', null, array('label' => false, 'attr' => array('placeholder' => 'user.register.type.name')))
        ->add('apellidos', null, array('label' => false, 'attr' => array('placeholder' => 'user.register.type.surnames')))
        ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
            'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
            'options' => array('translation_domain' => 'messages'),
            'first_options' => array('label' => false, 'attr' => array('placeholder' => 'user.register.type.passwd')),
            'second_options' => array('label' => false, 'attr' => array('placeholder' => 'user.register.type.passws-2')),
            'invalid_message' => 'fos_user.password.mismatch',
        ))
    ;
  }

  public function getBlockPrefix() {
    return 'app_user_profile';
  }

  public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User',
            'csrf_protection' => false,
            'translation_domain' => 'messages'
        ));
    }
}
