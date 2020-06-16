<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, [
                "label" => "user.email",
            ])
            ->add('message', TextareaType::class, [
                "label" => "message",
                'constraints' => [
                    new NotBlank([
                        'message' => 'user.message',
                    ]),
                    new Length([
                        'min' => 50,
                        'minMessage' => 'Your message should be at least {{ limit }} characters.',
                        // max length allowed by Symfony for security reasons
                        'max' => 255,
                    ]),
                ],
            ]);
        // ->add('send', SubmitType::class, ['label' => 'send']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            //'data_class' => Contact::class,
        ]);
    }
}
