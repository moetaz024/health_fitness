<?php

namespace App\Form;

use App\Entity\Coach;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class CoachType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('specialite')
            ->add('biographie')
            ->add('experience')

            // ✅ Upload field (مش مربوط مباشرة بالـEntity)
            ->add('photoFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Photo coach',
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Upload صورة (jpg/png/webp) فقط',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coach::class,
        ]);
    }
}
