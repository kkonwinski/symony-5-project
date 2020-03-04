<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
//            ->add('password')
            //mapowanie i walidacja pozycji których nie ma w encjach i nie można zastosować anotacji encji jak np w przypadku pozycji email
            ->add("plainPassword", PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => "Choose the password!"
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => "Coś za krótkie to hasło"
                    ])
                ]
            ])
            ->add('agreedTermsAt', CheckboxType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
