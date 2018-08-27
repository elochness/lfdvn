<?php
/**
 * Created by PhpStorm.
 * User: INUFRAP
 * Date: 18/07/2018
 * Time: 12:21
 */

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname',TextType::class, [
                'required' => true,
                'label' => 'label.lastname'
            ])
            ->add('firstname',TextType::class, [
                'required' => true,
                'label' => 'label.firstname'
            ])
            ->add('cellphone',TelType::class,	[
                'required' => true,
                'label' => 'label.telephone'
            ])
            ->add('username',EmailType::class, [
                'required' => true,
                'label' => 'label.email',
                'help' => 'help.email',
            ])
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'label.password'),
                'second_options' => array('label' => 'label.password_repeat'),
                'constraints'    => array(new NotBlank(array("message" => "user.password.not_blank")),
                                          new Length(array("max" => "4096")))
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }

}