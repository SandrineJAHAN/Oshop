<?php

namespace App\Controllers;

use App\Models\Category;


class CategoryController extends CoreController
{
    // initialisation du viewData

    /**
     * Liste des catégories
     *
     * @return void
     */
    public function list()
    {

        $viewData = [];

        $categories = Category::findAll();

        $viewData['categories'] = $categories;

        $this->show("category/list", $viewData);
    }

    /**
     * Appel la page d'édition d'une catégorie
     *
     * @param [int] $id
     * @return void
     */
    public function edit($id)
    {

        $category = Category::find($id);

       
        $viewData = [];
        $viewData['category'] = $category;

        $this->show("category/addUpdate", $viewData);
    }

    /**
     * Méthode permettant de mettre à jour une catégorie
     *
     * @param [int] $id
     * @return void
     */
    public function update($id)
    {
 
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
        $subtitle = filter_input(INPUT_POST, "subtitle", FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, "picture", FILTER_VALIDATE_URL);

        
        $category = Category::find($id);

        
        $category->setName($name);
        $category->setSubtitle(($subtitle));
        $category->setPicture(($picture));

        
        if ($category->save()) {
            
           

            header("Location: " . $this->router->generate("category-list"));
            
            exit;
        } else {
            echo ("problème lors de l'enregistrement");
        }
    }

    /**
     * Appel la page d'ajout d'une catégorie
     *
     * @return void
     */
    public function add()
    {
        $tokenCSRF = $this->generateToken();
        // on injecte une catégorie vide
        $category = new Category();
        // afficher le formulaire
        $this->show("category/addUpdate", ['category' => $category, 'tokenCSRF' => $tokenCSRF]);
    }

    /**
     * Création d'une nouvelle catégorie : enregistrement
     *
     * @return void
     */
    public function create()
    {

        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
        $subtitle = filter_input(INPUT_POST, "subtitle", FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, "picture", FILTER_VALIDATE_URL);

        $category = new Category();

      
        $category->setName($name);
        $category->setSubtitle(($subtitle));
        $category->setPicture(($picture));

        if ($category->save()) {


            header("Location: " . $this->router->generate("category-list"));
     
            exit;
        } else {
            echo ("problème lors de l'enregistrement");
        }
    }

    public function delete($id)
    {
       
        $category = Category::find($id);

        if ($category->delete()) {

            header("Location: " . $this->router->generate("category-list"));
            
            exit;
        } else {
            echo ("problème lors de l'enregistrement");
        }
    }

    public function homeOrder()
    {
        // récupération les catégories
        $categories = Category::findAll();
        // affichage de la vue
        $this->show("category/homeOrder", ['categories' => $categories]);
    }

    public function homeOrderPost()
    {
        // on prépare le tableau des erreurs
        $errorList = [];

        // on ré-initialise tous les home-order
        $categories = Category::findAll();
        foreach ($categories as $category) {
            $category->setHomeOrder(0);
            $category->save();
        }

        // on parcourt le tableau des emplacements
        $emplacements = filter_input(INPUT_POST,'emplacement', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

        foreach ($emplacements as $index => $categoryId) {
            // récupération de l'objet category à modifier (false si la catégorie n'existe pas)
            if ($categoryId === "") {
                $errorList[] = "Pas de catégorie sélectionnée pour l'emplacement " . ($index + 1);
            } else {
                // récupération de la catégorie
                $category = Category::find($categoryId);
                if ($category === false) {
                    $errorList[] = "La catégorie sélectionnée n'existe pas pour l'emplacement " . ($index + 1);
                } else {
                    if ($category->getHomeOrder() != 0) {
                        $errorList[] = "La catégorie sélectionnée pour l'emplacement " . ($index + 1) . " a déjà été sélectionnée sur un autre emplacement";
                    } else {
                        $category->setHomeOrder($index + 1);
                        if (!$category->save()) {
                            $errorList[] = "La catégorie n'a pas été sauvegardée pour l'emplacement " . ($index + 1);
                        }
                    }
                }
            }
        }

        // on vérifie l'absence d'erreurs
        if (empty($errorList)) {
            // redirection vers le même formulaire
            header('Location: ' . $this->router->generate('category-homeorder'));
            exit;
        }

        // si on arrive ici c'est qu'il y a eu des erreurs
        // on affiche la page avec les erreurs détectées
        // récupération les catégories
        $categories = Category::findAll();
        // affichage de la vue
        $this->show("category/homeOrder", [
            'categories' => $categories,
            'errorList'  => $errorList
        ]);
    }
}
