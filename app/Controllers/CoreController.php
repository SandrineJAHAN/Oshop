<?php

namespace App\Controllers;

abstract class CoreController
{
    protected $router;
    protected $match;

    /**
     * Création et stockage en $-SESSION d'un tokenCSRF
     *
     * @return tokenCSRF
     */
    public function generateToken()
    {
        // génération d'une chaine aléatoire
        $tokenCSRF = bin2hex(random_bytes(30));
        // on le stocke en session
        $_SESSION['tokenCSRF'] = $tokenCSRF;

        // on le retourne au controlleur pour utilisation dasn un formulaire
        return $tokenCSRF;
    }

    public function __construct($router, $match)
    {
        $this->router = $router;
        $this->match = $match;


        $acl = [
            "main-home"                 => ['admin', 'catalog-manager'],
            "category-list"             => ['admin', 'catalog-manager',],
            "category-add"              => ['admin', 'catalog-manager',],
            "category-create"           => ['admin', 'catalog-manager',],
            "category-edit"             => ['admin', 'catalog-manager',],
            "category-update"           => ['admin', 'catalog-manager',],
            "category-delete"           => ['admin', 'catalog-manager',],
            "product-list"              => ['admin', 'catalog-manager',],
            "product-add"               => ['admin', 'catalog-manager',],
            "product-create"            => ['admin', 'catalog-manager',],
            "product-edit"              => ['admin', 'catalog-manager',],
            "product-update"            => ['admin', 'catalog-manager',],
            "product-delete"            => ['admin', 'catalog-manager',],
            "appuser-list"              => ['admin',],
            "appuser-add"               => ['admin',],
            "appuser-create"            => ['admin',],
            "appuser-edit"              => ['admin',],
            "appuser-update"            => ['admin',],
            "appuser-delete"            => ['admin',],
        ];

        if ($match && array_key_exists($match['name'], $acl)) {
            // puisque elle est protégée, on récupère les rôles qui y ont accès
            $authorizedRoles = $acl[$match['name']];
            // on peut alors invoquer la méthode checkAutorization
            $this->checkAuthorization($authorizedRoles);
        }



        
        $csrfRoutes = [
            'category-create',
            'category-update',
        ];

       
        if ($match && in_array($match['name'], $csrfRoutes)) {
            // récupération des tokens du post et de la session
            $tokenPost    = $_POST['tokenCSRF'] ?? '';
            $tokenSession = $_SESSION['tokenCSRF'] ?? '';
            if (!empty($_SESSION['tokenCSRF'])) {
                unset($_SESSION['tokenCSRF']);
            }

            if (
                empty($tokenPost) ||
                empty($tokenSession) ||
                $tokenPost != $tokenSession
            ) {
                header('HTTP/1.0 403 Forbidden');
                $this->show('error/err403');
                exit;
            }
        }
    }

    /**
     * Fonction permettant de s'assurer que l'utilisateur connecté a bien les droits requis
     *
     * @param array $authorizedRoles tableau de rôles autorisés pour la fonctionnalité
     * @return boolean
     */
    public function checkAuthorization($authorizedRoles = [])
    {
        // L'utilisateur est il connecté
        if (array_key_exists('user', $_SESSION)) {
            // on récupère l'utilisateur
            $user = $_SESSION['user'];
            // le role de l'utilisateur est il suffisant pour accèder à la fonctionnalité
            if (in_array($user->getRole(), $authorizedRoles)) {
                // si oui, on autorise return true
                return true;
            } else {
                // si non, on l'informe qu'il n'a pas les droits, renvoi vers erreur 403
                header('HTTP/1.0 403 Forbidden');
                $this->show('error/err403');
                exit;
            }
        } else {
            // si pas connecté alors refus d'accès à la fonctionnalité, renvoi vers le login
            header('Location: ' . $this->router->generate('appuser-login'));
            exit;
        }
    }


    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {
        // global $router;
        $router = $this->router;
        $match = $this->match;

        $viewData['currentPage'] = $viewName;

        // définir l'url absolue pour nos assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        extract($viewData);

        dump(get_defined_vars());
        dump($_SESSION);

        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }
}
