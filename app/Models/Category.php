<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var int
     */
    private $home_order;

    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of home_order
     */
    public function getHomeOrder()
    {
        return $this->home_order;
    }

    /**
     * Set the value of home_order
     */
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;
    }

    /**
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     *
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    static public function find($categoryId)
    {
        
        $pdo = Database::getPDO();

        
        $sql = 'SELECT * FROM `category` WHERE `id` =' . $categoryId;

       
        $pdoStatement = $pdo->query($sql);


        $category = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $category;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category
     *
     * @return Category[]
     */
    static public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $results;
    }

    /**
     * Récupérer les 5 catégories mises en avant sur la home
     *
     * @return Category[]
     */
    public function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM category
            WHERE home_order > 0
            ORDER BY home_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $categories;
    }

    /**
     * Méthode permettant de récupérer les $n premiers enregistrements de la table category
     *
     * @return Category[]
     */
    static public function findFirst($n)
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category` LIMIT ' . $n;
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $results;
    }

    /**
     * Méthode permettant d'ajouter un enregistrement dans la table categorie
     *
     * @return bool
     */
    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();
        // écriture de la requête préparée utilisant des paramêtres fictifs
        $sql = "
            INSERT INTO `category` (name, subtitle, picture)
            VALUES ( :name, :subtitle, :picture);
                ";

        // on prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // liaison des paramètres fictifs
        $pdoStatement->bindValue(":name",       $this->name,        PDO::PARAM_STR);
        $pdoStatement->bindValue(":subtitle",   $this->subtitle,    PDO::PARAM_STR);
        $pdoStatement->bindValue(":picture",    $this->picture,     PDO::PARAM_STR);

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

    /**
     * Mise à jour dans la base de donnée
     *
     * @return boolean
     */
    public function update()
    {

        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // écriture de la requête préparée utilisant des paramêtres fictifs
        $sql = "
        UPDATE `category`
        SET name=:name, subtitle=:subtitle, picture=:picture, home_order=:home_order
        WHERE id=:id; 
        ";

        // on prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // liaison des paramètres fictifs
        $pdoStatement->bindValue(":name",       $this->name,        PDO::PARAM_STR);
        $pdoStatement->bindValue(":subtitle",   $this->subtitle,    PDO::PARAM_STR);
        $pdoStatement->bindValue(":picture",    $this->picture,     PDO::PARAM_STR);
        $pdoStatement->bindValue(":id",         $this->id,          PDO::PARAM_INT);
        $pdoStatement->bindValue(":home_order", $this->home_order,  PDO::PARAM_INT);

        // Execution de la requête préparée
        $pdoStatement->execute();

        // Si au moins une ligne modifiée
        if ($pdoStatement->rowCount() === 1) {
            // On retourne VRAI car l'ajout a fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }
        // si on arrive ici, c'est que quelque chose c'est mal passé
        return false;
    }

    public function delete()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // écriture de la requête préparée utilisant des paramêtres fictifs
        $sql = "
                DELETE FROM `category` WHERE id=:id;
                ";

        // on prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // liaison des paramètres fictifs
        $pdoStatement->bindValue(":id",         $this->id,          PDO::PARAM_INT);

        // Execution de la requête préparée
        $pdoStatement->execute();

        // Si au moins une ligne supprimée
        if ($pdoStatement->rowCount() === 1) {
            // On retourne VRAI car l'ajout a fonctionné
            return true;
        }
        // si on arrive ici, c'est que quelque chose c'est mal passé
        return false;
    }
}
