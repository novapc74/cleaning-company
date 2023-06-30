<?php

namespace App\Form;

use App\Entity\FeedBack;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class FeedBackFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Имя',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('connectionType', ChoiceType::class, [
                'label' => 'Тип связи',
                'choices' => FeedBack::getAvailableConnectionType(),
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'Телефон',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('comment', TextType::class, [
                'label' => 'Комментарий'
            ])
            ->add('agreeTerm', CheckboxType::class, [
                'label' => 'Пользовательское соглашение',
                'label_html' => true,
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FeedBack::class,
        ]);
    }
}