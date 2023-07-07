<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LocationCrudController extends AbstractCrudController
{
	public static function getEntityFqcn(): string
	{
		return Location::class;
	}

	public function configureFields(string $pageName): iterable
	{
		return [
			TextField::new('title', 'локация')
				->setTextAlign('center')
			,
			SlugField::new('slug', 'слаг')
				->setTargetFieldName('title')
				->setTextAlign('center')
			,
			TextField::new('coordinates', 'координаты')
				->setTextAlign('center')
			,
		];
	}
}
