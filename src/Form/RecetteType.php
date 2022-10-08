<?php

namespace App\Form\Type;

use App\Enum\CategoryType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

class RecetteType  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class)
            ->add('Descriptions', TextType::class)
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => false, 
                'mapped' => false,
                'required' => false
            ])
            ->add('Category', EnumType::class, ['class' => CategoryType::class] )
            ->add('save', SubmitType::class)
        ;
    }
}