<?php

namespace App\Form;

use App\Entity\User;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    private $router;
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, [
                "label" => "user.email",
            ])
            ->add('agreeTerms', CheckboxType::class, [
                "label" => "user.terms",
                "label_translation_parameters" => [
                    "%url%" => $this->router->generate('mentions-legales')
                ],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'user.terms_message',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                "label" => "user.password",
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'user.password_message',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            // Ajout du submit
            // ->add('save', SubmitType::class, [
            //     'label' => 'user.save'
            // ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
