<?php

namespace App\Controllers;


use App\Models\Category;
use App\Models\Product;

class MainController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function home()
    {

        // catégorie
        $categories = Category::findFirst(3);

        // produits
        $products = Product::findAll();
        $products = array_slice($products, 0, 3);

        // on transfère à la vue
        $viewData = [];
        $viewData['categories'] = $categories;
        $viewData['products'] = $products;


        // On appelle la méthode show() de l'objet courant
        $this->show('main/home', $viewData);
    }
}
