<?php

namespace App\Controllers;

use App\Models\AppUser;

class AppUserController extends CoreController
{
    /**
     * Liste des utilisateurs
     *
     * @return void
     */
    public function list()
    {
        // // vérification de l'autorisation d'accès à la méthode

        // initialisation du viewData
        $viewData = [];

        // utilisation de méthode statique
        $users = AppUser::findAll();

        // les passer en paramètre à la vue
        $viewData['users'] = $users;

        // Afficher la vue des utilisateurs
        $this->show("appuser/list", $viewData);
    }
    /**
     * Envoi vers le formulaire de connexion
     *
     * @return void
     */
    public function login()
    {
        $this->show("appuser/login");
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: ' . $this->router->generate('appuser-login'));
    }

    /**
     * Vérifie que l'utilisateur existe et que son mot de passe est OK
     *
     * @return void enrgistre l'utilisateur connecté en $_SESSION
     */
    public function validate()
    {
        // récupération des données du $_POST
        $email    = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        // on gère une liste d'erreurs 
        $errorList = [];

        // on vérifie que l'utilisateur existe
        // on utilise la méthode statique findByEmail($email)
        $user = AppUser::findByEmail($email);

        // si on trouve un résultat pour l'email, on retourne une instance de AppUser
        // sinon, on retourne false
        if ($user) {
            // si $user n'est pas faux, il contient une instance de AppUser
            //comparer le password fourni et le password de l'objet
            if (password_verify($password, $user->getPassword())) {
                // s'ils sont égaux
                // enregistrer l'utilisateur connecté dans la session
                $_SESSION['user'] = $user;
                header('Location: ' . $this->router->generate('main-home'));
            } else {
                $errorList[] = "Identifiant incorrect";
            }
        } else {
            $errorList[] = "Identifiant incorrect";
        }

        $this->show('appuser/login', ['errorList' => $errorList]);
    }

    /**
     * Appel la page d'ajout d'une catégorie
     *
     * @return void
     */
    public function add()
    {

        // on injecte un utilisateur vide
        $user = new AppUser();
        // afficher le formulaire
        $this->show("appuser/addUpdate", ['user' => $user]);
    }



    /**
     * Créer ou mettre à jour en base de donnée
     *
     * @param [int] $id
     * @return void
     */
    public function createOrUpdate($id = null)
    {
        // On tente de récupèrer les données venant du formulaire.
        $email =        filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $password =     filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);
        $firstname =    filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING);
        $lastname =     filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_STRING);
        $role =         filter_input(INPUT_POST, "role", FILTER_SANITIZE_STRING);
        $status =       filter_input(INPUT_POST, "status", FILTER_VALIDATE_INT);

        // Préparation du traitement en fonction de mise à jour ou non
        if (isset($id) === true) {
            // On cherche l'utilisateur qui match l'id demandé.
            $user = AppUser::find($id);
        } else {
            // on crée une instance d'utilisateur
            $user = new AppUser();
        }

        // On met à jour les propriétés de l'instance.
        $user->setEmail($email);
        $user->setFirstname(($firstname));
        $user->setLastname(($lastname));
        $user->setRole($role);
        $user->setStatus($status);
        $user->setPassword((password_hash($password, PASSWORD_DEFAULT)));

        // On tente de sauvegarder les données en DB...
        if ($user->save()) {
            // Si la sauvegarde a fonctionné, on redirige vers la liste des utilisateurs.

            header("Location: " . $this->router->generate("appuser-list"));
            exit;
        } else {

            // Sinon, on ajoute un message d'erreur à la page actuelle, et on laisse
            // l'utilisateur retenter la création.
            $errorList[] = 'La sauvegarde a échoué';
        }
    }
}
