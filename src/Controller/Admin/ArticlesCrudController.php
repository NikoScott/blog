<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ArticlesCrudController extends AbstractCrudController
{
    private $params;

    public function __construct(ParameterBagInterface $params) 
    {
    
        $this->params = $params;
    }

    public static function getEntityFqcn(): string
    {
        return Articles::class;
    }

    public function configureFilters(Filters $filters ): Filters
    {
        return $filters
            ->add('title')
            ->add('date')
            ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud

            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('catchPhrase'),
            DateField::new('date'),
            TextField::new('author'),
            TextareaField::new('description')
                ->setFormType(CKEditorType::class), 
            AssociationField::new('category'),
            ImageField::new('picture')
            ->setUploadDir('public/images/articles')
            ->setBasePath($this->params->get('app.path.article_images'))
            ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]')
            ->setRequired(false),
            CollectionField::new('relatedSubjects'),
            TextField::new('legendMainPicture'),
            TextField::new('authorWebsite'),
        ];
    }

}
