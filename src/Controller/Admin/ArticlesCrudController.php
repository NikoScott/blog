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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
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
            ->add('category')
            ->add('authorWebsite')
            ;
    }
       
 
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title','Titre'),
            TextField::new('catchPhrase',"Phrase d'accroche"),
            DateField::new('date'),
            TextField::new('author','Auteur'),
            TextEditorField::new('description','Description'),
            ImageField::new('picture','Photo')
            ->setUploadDir('public/images/articles')
            ->setBasePath($this->params->get('app.path.article_images'))
            ->setUploadedFileNamePattern('[slug]-[contenthash].[extension]')
            ->setRequired(false),
            TextField::new('legendMainPicture','Légende de la photo'),
            TextField::new('authorWebsite',"Site de l'auteur"),
            AssociationField::new('category','Catégorie'),
            CollectionField::new('relatedSubjects','Hashtag/Sujet'),
        ];
    }
}