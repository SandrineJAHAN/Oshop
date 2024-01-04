<?php

namespace App\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Type;

class ProductController extends CoreController
{
    // initialisation du viewData


    public function list()
    {
        // initialisation du viewData
        $viewData = [];

        // utilisation de méthode statique
        $products = Product::findAll();

        // les passer en paramètre à la vue
        $viewData['products'] = $products;

        // Afficher la vue des produits
        $this->show("product/list", $viewData);
    }

    public function edit($id)
    {
        // dump($id);

        // on récupère le produit $id
        $product = Product::find($id);

        // on récupère les catégories, types et marques pour dynamiser les listes
        $categories = Category::findAll();
        $types      = Type::findAll();
        $brands     = Brand::findAll();

        // on les transmet à la vue
        $viewData = [];
        $viewData['product']    = $product;
        $viewData['categories'] = $categories;
        $viewData['types']      = $types;
        $viewData['brands']     = $brands;

        // on ajoute la liste de Tag du produit à la Viewdata
        $productTags = $product->findAllTags();
        $viewData['productTags'] = $productTags;

        // on ajoute la liste de tous les Tag à la Viewdata
        $tags = Tag::findAll();
        $viewData['tags'] = $tags;

        // on apelle la vue
        $this->show("product/addUpdate", $viewData);
    }

    public function createOrUpdate($id = null)
    {
        dd($_POST);
        // On tente de récupèrer les données venant du formulaire.
        $name =         filter_input(INPUT_POST, 'name',        FILTER_SANITIZE_STRING);
        $description =  filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $picture =      filter_input(INPUT_POST, 'picture',     FILTER_VALIDATE_URL);
        $price =        filter_input(INPUT_POST, 'price',       FILTER_VALIDATE_FLOAT);
        $rate =         filter_input(INPUT_POST, 'rate',        FILTER_VALIDATE_INT);
        $status =       filter_input(INPUT_POST, 'status',      FILTER_VALIDATE_INT);
        $brand_id =     filter_input(INPUT_POST, 'brand_id',    FILTER_VALIDATE_INT);
        $category_id =  filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $type_id =      filter_input(INPUT_POST, 'type_id',     FILTER_VALIDATE_INT);

        if (isset($id) === true) {
            // On cherche le produit qui match l'id demandé.
            $product = Product::find($id);
        } else {
            // On instancie un nouveau modèle de type Category.
            $product = new Product();
        }

        // On met à jour les propriétés de l'instance.
        $product->setName($name);
        $product->setDescription($description);
        $product->setPicture($picture);
        $product->setPrice($price);
        $product->setRate($rate);
        $product->setStatus($status);
        $product->setBrandId($brand_id);
        $product->setCategoryId($category_id);
        $product->setTypeId($type_id);

        // On tente de sauvegarder les données en DB...
        if ($product->save()) {
            // Si la sauvegarde a fonctionné, on redirige vers la liste des product.

            header("Location: " . $this->router->generate("product-list"));
            exit;
        } else {

            // Sinon, on ajoute un message d'erreur à la page actuelle, et on laisse
            // l'utilisateur retenter la création.
            $errorList[] = 'La sauvegarde a échoué';
        }
    }

    /**
     * Appel la page d'ajout d'un produit
     *
     * @return void
     */
    public function add()
    {

        // on injecte un produit vide
        $product = new Product();

        // on récupère les catégories, types et marques pour dynamiser les listes
        $categories = Category::findAll();
        $types      = Type::findAll();
        $brands     = Brand::findAll();

        // afficher le formulaire
        $this->show("product/addUpdate", [
            'categories'    => $categories,
            'types'         => $types,
            'brands'        => $brands,
            'product'       => $product
        ]);
    }
    /**
     * Suppression d'une catégorie
     *
     * @param [int] $id
     * @return void
     */
    public function delete($id)
    {
        $product = Product::find($id);

        if ($product->delete()) {
            // La suppression a fonctionné
            header("Location: ".$this->router->generate("product-list"));
            exit;
        } else {
            $errorList[] = 'La suppression a échoué';
        }
    }
}
