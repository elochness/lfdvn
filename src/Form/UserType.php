<?php

/*
 * This file is part of the lfdvn package.
 *
 * (c) Pierre François
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, [
                'required' => true,
                'label' => 'label.lastname',
            ])
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'label.firstname',
            ])
            ->add('cellphone', TelType::class, [
                'required' => true,
                'label' => 'label.telephone',
            ])
            ->add('username', EmailType::class, [
                'required' => true,
                'label' => 'label.email',
                'help' => 'help.email',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'label.password'],
                'second_options' => ['label' => 'label.password_repeat'],
                'constraints' => [new NotBlank(['message' => 'user.password.not_blank']),
                                          new Length(['max' => '4096']), ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
