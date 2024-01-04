<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Un modèle représente une table (un entité) dans notre base
 *
 */
class AppUser extends CoreModel
{

    /**
     * @var string $email Adresse email de l'utilisateur
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $role;

    /**
     * @var int
     */
    private $status;


    /**
     * Get $email Adresse email de l'utilisateur
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set $email Adresse email de l'utilisateur
     *
     * @param  string  $email  $email Adresse email de l'utilisateur
     *
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of firstname
     *
     * @return  string
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  string  $firstname
     *
     * @return  self
     */ 
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     *
     * @return  string
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string  $lastname
     *
     * @return  self
     */ 
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of role
     *
     * @return  string
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @param  string  $role
     *
     * @return  self
     */ 
    public function setRole(string $role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     *
     * @return  self
     */ 
    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

   /**
     * Méthode permettant de récupérer un enregistrement de la table app_user en fonction d'un id donné
     *
     * @param int $id ID de l'utilisateur
     * @return AppUser
     */
    static public function find($id)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `app_user` WHERE `id` = :id;';

        // préparer notre requête
        $pdoStatement = $pdo->prepare($sql);
        // on lie les arguments
        $pdoStatement->bindValue(':id', $id, PDO::PARAM_INT);
        // on exécute
        $pdoStatement->execute();

        // retourner le résultat
        return $pdoStatement->fetchObject(self::class);;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table app_user
     *
     * @return AppUser[]
     */
    static public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }

    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        $sql = "
            INSERT INTO `app_user` (
              email,
              password,
              firstname,
              lastname,
              role,
              status
            )
            VALUES (
                :email,
                :password,
                :firstname,
                :lastname,
                :role,
              :status
            );
        ";

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':email',         $this->email,       PDO::PARAM_STR);
        $pdoStatement->bindValue(':password',      $this->password,    PDO::PARAM_STR);
        $pdoStatement->bindValue(':firstname',     $this->firstname,   PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname',      $this->lastname,    PDO::PARAM_STR);
        $pdoStatement->bindValue(':role',          $this->role,        PDO::PARAM_STR);
        $pdoStatement->bindValue(':status',        $this->status,      PDO::PARAM_INT);

        // Puis exécuter la requête SQL préparée
        $pdoStatement->execute();

        // Si une ligne ajoutée
        if (1 === $pdoStatement->rowCount()) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
        }

        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    /**
     * Modification d'un utilisateur dans la BDD
     *
     * @return boolean
     */
    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE en préparé
        $sql = "
            UPDATE `app_user`
            SET
                `email` = :email, 
                `password` = :password,
                `firstname` = :firstname,
                `lastname` = :lastname,
                `role` = :role,
                `status` = :status,
                `updated_at` = NOW()
            WHERE `id` = :id;
        ";

        // on prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // liaison des paramètres fictifs
        $pdoStatement->bindValue(':email',         $this->email,       PDO::PARAM_STR);
        $pdoStatement->bindValue(':password',      $this->password,    PDO::PARAM_STR);
        $pdoStatement->bindValue(':firstname',     $this->firstname,   PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname',      $this->lastname,    PDO::PARAM_STR);
        $pdoStatement->bindValue(':role',          $this->role,        PDO::PARAM_STR);
        $pdoStatement->bindValue(':status',        $this->status,      PDO::PARAM_INT);

        $pdoStatement->bindValue(":id",            $this->id,          PDO::PARAM_INT);

        // Execution de la requête d'insertion 
        $pdoStatement->execute();

        // Si une ligne modifiée
        if (1 === $pdoStatement->rowCount()) {
            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }
        // affichage du message d'erreur
        return false;
    }

    /**
     * Suppression d'un utilisateur dans la base de données
     *
     * @return boolean
     */
    public function delete()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE en préparé
        $sql = "
                DELETE FROM `app_user`
                WHERE `id` = :id;
            ";

        // on prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // liaison des paramètres fictifs
        $pdoStatement->bindValue(":id",         $this->id,          PDO::PARAM_INT);

        // Execution de la requête d'insertion 
        $pdoStatement->execute();

        // Si une ligne supprimée
        if (1 === $pdoStatement->rowCount()) {
            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
        }
        return false;
    }

    static public function findByEmail($email) {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire la requête préparée
        $sql = '
        SELECT *
        FROM app_user
        WHERE email = :email;
        ';

        // on prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // liaison du paramètre fictif
        $pdoStatement->bindValue(":email", $email, PDO::PARAM_STR);

        // exécution de la requête
        $pdoStatement->execute();

        // récupération de l'éventuel user et renvoi
        return $pdoStatement->fetchObject(self::class);
    }
}