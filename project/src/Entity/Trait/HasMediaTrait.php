<?php

namespace App\Entity\Trait;

use App\Entity\Media;
use Symfony\Component\Serializer\Annotation\Groups;
use TypeError;

trait HasMediaTrait
{
	public function uploadNewMedia(?Media $fieldMedia, string $fieldName): void
	{
		if (!property_exists($this, $fieldName)) {
			throw new TypeError('У объекта нет заявленного свойства');
		}
		$fieldGetterMethod = self::mediaGetter($fieldName);
		$fieldSetterMethod = self::mediaSetter($fieldName);
		if (!method_exists($this, $fieldGetterMethod) || !method_exists($this, $fieldSetterMethod)) {
			throw new TypeError('У объекта не объявлены методы для заявленного свойства');
		}
		$oldMediaFile = $this->$fieldGetterMethod()?->getUploadedFile();
		if ($oldMediaFile !== $fieldMedia?->getUploadedFile()) {
			$newMedia = clone $fieldMedia;
			$this->$fieldSetterMethod($newMedia);
		}
	}

	public static function mediaGetter($property_name): string
	{
		return 'get' . self::toCamelCase($property_name);
	}

	public static function mediaSetter($property_name): string
	{
		return 'set' . self::toCamelCase($property_name);
	}

	private static function toCamelCase($string): string
	{
		$string = str_replace('_', ' ', $string);
		$string = ucwords($string);
		return str_replace(' ', '', $string);
	}
}
