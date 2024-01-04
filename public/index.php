<?php
// POINT D'ENTRÉE UNIQUE :
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
require_once '../vendor/autoload.php';
session_start();

// imporation des classes nécessaires

use App\Controllers\MainController;
use App\Controllers\AppUserController;
use App\Controllers\ProductController;
use App\Controllers\CategoryController;
use App\Models\AppUser;

/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else { // sinon
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter,
// afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : informations contenant
//      - le nom de la méthode à utiliser pour répondre à cette route
//      - le nom du controller contenant la méthode
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"
$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => MainController::class // On indique le FQCN de la classe
    ],
    'main-home'
);

// déclaration des routes pour les catégories
$router->map('GET',     '/category/list',           ['method'=>'list',      'controller'=>CategoryController::class], 'category-list');
$router->map('GET',     '/category/add',            ['method'=>'add',       'controller'=>CategoryController::class], 'category-add');
$router->map('POST',    '/category/add',            ['method'=>'create',    'controller'=>CategoryController::class], 'category-create');
$router->map('GET',     '/category/update/[i:id]',  ['method'=>'edit',      'controller'=>CategoryController::class], 'category-edit');
$router->map('POST',    '/category/update/[i:id]',  ['method'=>'update',    'controller'=>CategoryController::class], 'category-update');
$router->map('GET',     '/category/delete/[i:id]',  ['method'=>'delete',    'controller'=>CategoryController::class], 'category-delete');
$router->map('GET',     '/category/homeorder',      ['method'=>'homeOrder', 'controller'=>CategoryController::class], 'category-homeorder');
$router->map('POST',    '/category/homeorder',      ['method'=>'homeOrderPost',    'controller'=>CategoryController::class], 'category-homeorder-post');

// déclaration des routes pour les produits
$router->map('GET',     '/product/list',           ['method'=>'list',      'controller'=>ProductController::class], 'product-list');
$router->map('GET',     '/product/add',            ['method'=>'add',       'controller'=>ProductController::class], 'product-add');
$router->map('POST',    '/product/add',            ['method'=>'createOrUpdate',    'controller'=>ProductController::class], 'product-create');
$router->map('GET',     '/product/update/[i:id]',  ['method'=>'edit',      'controller'=>ProductController::class], 'product-edit');
$router->map('POST',    '/product/update/[i:id]',  ['method'=>'createOrUpdate',    'controller'=>ProductController::class], 'product-update');
$router->map('GET',     '/product/delete/[i:id]',  ['method'=>'delete',    'controller'=>ProductController::class], 'product-delete');

// Déclaration des routes pour les utilisateurs
$router->map('GET',     '/login',                   ['method'=>'login',      'controller'=>AppUserController::class], 'appuser-login');
$router->map('POST',    '/login',                   ['method'=>'validate',   'controller'=>AppUserController::class], 'appuser-validate');
$router->map('GET',     '/logout',                  ['method'=>'logout',     'controller'=>AppUserController::class], 'appuser-logout');
$router->map('GET',     '/user/list',               ['method'=>'list',       'controller'=>AppUserController::class], 'appuser-list');
$router->map('GET',     '/user/add',                ['method'=>'add',       'controller'=>AppUserController::class], 'appuser-add');
$router->map('POST',    '/user/add',                ['method'=>'createOrUpdate',    'controller'=>AppUserController::class], 'appuser-create');
$router->map('GET',     '/user/update/[i:id]',      ['method'=>'edit',      'controller'=>AppUserController::class], 'appuser-edit');
$router->map('POST',    '/user/update/[i:id]',      ['method'=>'createOrUpdate',    'controller'=>AppUserController::class], 'appuser-update');
$router->map('GET',     '/user/delete/[i:id]',      ['method'=>'delete',    'controller'=>AppUserController::class], 'appuser-delete');

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// le routeur s'arrête ici !!!!!!!!!!!!!!!!!!!

/* -------------
--- DISPATCH ---
--------------*/

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
// Setup controllers argument(s)
$dispatcher->setControllersArguments($router, $match);
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();
