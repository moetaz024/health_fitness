<?php

namespace App\Form;

<<<<<<< HEAD
use App\Entity\Coach;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
=======
use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
>>>>>>> 82a889c (fixed admin dashboard)

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('prix')
            ->add('duree')
            ->add('categorie')
<<<<<<< HEAD
            ->add('image')
            ->add('coach', EntityType::class, [
                'class' => Coach::class,
                'choice_label' => 'id',
            ])
        ;
=======
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Image',
            ])
            ->add('coach');
>>>>>>> 82a889c (fixed admin dashboard)
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
