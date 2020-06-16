<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Image;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                "label" => "event.title",
            ])
            ->add('content', null, [
                "label" => "event.content",
            ])
            ->add('created_at', null, [
                "label" => "event.created_at",
            ])
            ->add('location', null, [
                "label" => "event.location",
            ])
            // Inclus le formulaire d'image dans le formulaire article
            ->add('image', ImageType::class, ['label' => false])
            ->add('deleteImage', CheckboxType::class, [
                'label' => 'event.delete_image',
                'required' => false, // Pas obligatoire
            ])
            ->add('categories', EntityType::class, [
                'label' => 'event.categories',
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EntityRepository $er) {
                    // Modifie la requête d'affichage de la liste des catégories
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.title', 'asc');
                },
            ])

            // Ajout du submit
            ->add('save', SubmitType::class, ['label' => 'save']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
