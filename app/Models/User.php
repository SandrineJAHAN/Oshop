<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Un modèle représente une table (un entité) dans notre base
 *
 */
class User extends CoreModel
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
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set $email Adresse email de l'utilisateur
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of firstname
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * Set the value of role
     */
    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    static public function find($userId)
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user` WHERE `id` =' . $userId;
        $pdoStatement = $pdo->query($sql);
        $user = $pdoStatement->fetchObject('App\Models\User');
        return $user;
    }

    static public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\User');

        return $results;
    }

    public function insert()
    {

        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        $sql = "
                INSERT INTO `app_user` (email, password, firstname, lastname, role, status)
                VALUES ( :email, :password, :firstname, :lastname, :role, :status);
                    ";

        // on prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // liaison des paramètres fictifs
        $pdoStatement->bindValue(":email",       $this->email,        PDO::PARAM_STR);
        $pdoStatement->bindValue(":password",    $this->password,     PDO::PARAM_STR);
        $pdoStatement->bindValue(":firstname",   $this->firstname,    PDO::PARAM_STR);
        $pdoStatement->bindValue(":lastname",    $this->lastname,     PDO::PARAM_STR);
        $pdoStatement->bindValue(":role",        $this->role,         PDO::PARAM_STR);
        $pdoStatement->bindValue(":status",      $this->status,       PDO::PARAM_INT);
        // Execution de la requête préparée
        $pdoStatement->execute();
        // Si au moins une ligne ajoutée
        // if ($insertedRows > 0) {
        if ($pdoStatement->rowCount() === 1) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }

        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    public function update()
    {
        $pdo = Database::getPDO();
        // SQL Query for UPDATE
        $sql = "
       UPDATE `app_user`
       SET

      
       email = :email, 
       password = :password,
       firstname = :firstname, 
       lastname = :lastname,
       role = :role,
       status =  :status, 
       updated_at = NOW(),
       
       WHERE id = :id;
   ";
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(":email",       $this->email,        PDO::PARAM_STR);
        $pdoStatement->bindValue(":password",    $this->password,     PDO::PARAM_STR);
        $pdoStatement->bindValue(":firstname",   $this->firstname,    PDO::PARAM_STR);
        $pdoStatement->bindValue(":lastname",    $this->lastname,     PDO::PARAM_STR);
        $pdoStatement->bindValue(":role",        $this->role,         PDO::PARAM_STR);
        $pdoStatement->bindValue(":status",      $this->status,       PDO::PARAM_INT);
        $pdoStatement->bindValue(":id", $this->id, PDO::PARAM_INT);

        $pdoStatement->execute();


        if ($pdoStatement->rowCount() === 1) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        $pdo = Database::getPDO();
        $sql = "
            DELETE FROM app_user
            WHERE id = :id
        ";
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->execute();
    }

    public function findByEmail($email)
    {

        $pdo = Database::getPDO();
        $sql = "
            SELECT * FROM app_user
            WHERE email = :email
        ";
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
        $pdoStatement->execute();

        return $pdoStatement->fetchObject(User::class);
    }
}
