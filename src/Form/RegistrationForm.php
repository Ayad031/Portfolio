<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;


class RegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('agreeTerms', CheckboxType::class, [ 
                'label' => 'J’accepte les conditions générales',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Acceptez les termes.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false, // Le mot de passe n'est pas mappé directement sur l'entité
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Veuillez entrer un mot de passe.',
                    ]),
                    new Assert\Length([
                        'min' => 8,
                        'minMessage' => 'Le mot de passe doit comporter au moins {{ limit }} caractères.',
                        'max' => 4096,
                    ]),
                    new Assert\Regex([
                        'pattern' => '/[A-Z]/',
                        'message' => 'Le mot de passe doit contenir au moins une lettre majuscule.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/[a-z]/',
                        'message' => 'Le mot de passe doit contenir au moins une lettre minuscule.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/\d/',
                        'message' => 'Le mot de passe doit contenir au moins un chiffre.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/[\W_]/', // Caractères spéciaux
                        'message' => 'Le mot de passe doit contenir au moins un caractère spécial (par exemple !, @, #, $, etc.).',
                    ]),
                ],
            ]);
            }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
