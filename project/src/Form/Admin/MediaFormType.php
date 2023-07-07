<?php

namespace App\Form\Admin;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class MediaFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('imageFile', VichImageType::class, [
				'label' => false,
				'by_reference' => false,
				'allow_delete' => true,
				'constraints' => [
					new Callback([
						$this,
						'validate'
					])
				]
			]);
	}

	public function validate(?UploadedFile $file, ExecutionContextInterface $context): void
	{
		if (!$file) {
			return;
		}

		if (!in_array($file->getMimeType(), ['image/jpg', 'image/jpeg', 'image/png', 'application/pdf'])) {
			$context->buildViolation(sprintf('%s -- не допустимое расширение, допустимые: jpg, jpeg, png', $file->getMimeType()))
				->atPath('imageFile')
				->addViolation();
		}

		$invalidFileNameLength = strlen($file->getClientOriginalName());

		if ($invalidFileNameLength >= 80) {
			$context->buildViolation(sprintf('Длина имени файла %s символа, что превышает допустимое значение в 80 символов!', $invalidFileNameLength))
				->atPath('imageFile')
				->addViolation();
		}
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => Media::class,
		]);
	}
}
