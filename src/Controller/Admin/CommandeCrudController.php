<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Produit;
use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    

    
    
    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('membre'),
            AssociationField::new('produit'),
            IntegerField::new('quantite'),
            IntegerField::new('montant'),
            ChoiceField::new('etat')
            ->setChoices([
                'En cours de traitement' => 'En cours de traitement',
                'Envoyé' => 'Envoyé',
                'Livré' => 'Livré',
            ])
            ->setLabel('Etat'),
            DateTimeField::new('date_enregistrement')->setFormat('d/m/Y à H:m:s')->hideOnForm(),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $commande = new $entityFqcn;
        $commande->setDateEnregistrement(new DateTime);
        return $commande;
    }

    
    
}

?>

