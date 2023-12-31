<?php

namespace App\Controller\Admin;

use App\Entity\Gallery;
use App\Form\Admin\MediaFormType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GalleryCrudController extends AbstractCrudController
{
	public static function getEntityFqcn(): string
	{
		return Gallery::class;
	}

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Изображение')
            ->setPageTitle(CRUD::PAGE_NEW, 'Загрузить новое изображение')
            ->setPageTitle(CRUD::PAGE_EDIT, "Обновить изображение")
            ->setEntityLabelInPlural('Галерея');
    }

	public function configureFields(string $pageName): iterable
	{
		return [
			ChoiceField::new('type')
				->setChoices(Gallery::getAvailableGalleryType())
				->setTextAlign('center')
				->setColumns('col-sm-6 col-lg-5 col-xxl-3')
			,
			FormField::addRow(),
			TextField::new('image', 'Файлы')
				->onlyOnIndex()
				->setTemplatePath('admin/crud/assoc_image.html.twig')
			,
			FormField::addPanel('Картинка')
				->setProperty('image')
				->setFormType(MediaFormType::class)
				->setFormTypeOptions([
					'by_reference' => false,
					'mapped' => true,
					'error_bubbling' => false,
				])
				->setColumns('col-sm-6 col-lg-5 col-xxl-3')
		];
	}
}
