<?php

namespace App\Form;

use App\Entity\ImportData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImportDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ...
            ->add('xlsx', FileType::class, [
                'label' => 'data (.xlsx)',
                'attr' => [
                    'class' => 'form-control'
                ],
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'application/xlsx'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid xlsx document',
                    ])
                ],
            ])
            // ...
            ->add('Extraire', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success d-block mx-auto mt-3'
    ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImportData::class,
        ]);
    }
}
