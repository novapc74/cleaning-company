<?php

namespace App\Form\Admin;

use App\Entity\Gallery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class GalleryType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('type', ChoiceType::class, [
				'label' => 'тип',
				'choices' => Gallery::getAvailableGalleryType()
			])
			->add('image', MediaFormType::class, [
				'label' => 'картинка',
				'by_reference' => false,
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Gallery::class,
		]);
	}
}
