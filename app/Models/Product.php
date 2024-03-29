<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Une instance de Product = un produit dans la base de données
 * Product hérite de CoreModel
 */
class Product extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var float
     */
    private $price;
    /**
     * @var int
     */
    private $rate;
    /**
     * @var int
     */
    private $status;
    /**
     * @var int
     */
    private $brand_id;
    /**
     * @var int
     */
    private $category_id;
    /**
     * @var int
     */
    private $type_id;

    /**
     * Méthode permettant de récupérer un enregistrement de la table Product en fonction d'un id donné
     *
     * @param int $id ID du produit
     * @return Product
     */
    static public function find($id)
    {
        // récupérer un objet PDO = connexion à la BDD
        $pdo = Database::getPDO();

        // on écrit la requête SQL pour récupérer le produit
        $sql = '
            SELECT *
            FROM product
            WHERE id = ' . $id;

        $pdoStatement = $pdo->query($sql);

        $result = $pdoStatement->fetchObject('App\Models\Product');

        return $result;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     *
     * @return Product[]
     */
    static public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `product`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Product');

        return $results;
    }

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
     * Get the value of description
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string  $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Get the value of picture
     *
     * @return  string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @param  string  $picture
     */
    public function setPicture(string $picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of price
     *
     * @return  float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param  float  $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * Get the value of rate
     *
     * @return  int
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @param  int  $rate
     */
    public function setRate(int $rate)
    {
        $this->rate = $rate;
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
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * Get the value of brand_id
     *
     * @return  int
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @param  int  $brand_id
     */
    public function setBrandId(int $brand_id)
    {
        $this->brand_id = $brand_id;
    }

    /**
     * Get the value of category_id
     *
     * @return  int
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @param  int  $category_id
     */
    public function setCategoryId(int $category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * Get the value of type_id
     *
     * @return  int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set the value of type_id
     *
     * @param  int  $type_id
     */
    public function setTypeId(int $type_id)
    {
        $this->type_id = $type_id;
    }

    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        $sql = "
            INSERT INTO `product` (
              name,
              description,
              picture,
              price,
              rate,
              status,
              brand_id,
              category_id,
              type_id
            )
            VALUES (
              :name,
              :description,
              :picture,
              :price,
              :rate,
              :status,
              :brand_id,
              :category_id,
              :type_id
            )
        ";

        $query = $pdo->prepare($sql);

        $query->bindValue(':name',          $this->name,        PDO::PARAM_STR);
        $query->bindValue(':description',   $this->description, PDO::PARAM_STR);
        $query->bindValue(':picture',       $this->picture,     PDO::PARAM_STR);
        $query->bindValue(':price',         $this->price,       PDO::PARAM_STR);
        $query->bindValue(':rate',          $this->rate,        PDO::PARAM_INT);
        $query->bindValue(':status',        $this->status,      PDO::PARAM_INT);
        $query->bindValue(':brand_id',      $this->brand_id,    PDO::PARAM_INT);
        $query->bindValue(':category_id',   $this->category_id, PDO::PARAM_INT);
        $query->bindValue(':type_id',       $this->type_id,     PDO::PARAM_INT);
        // Puis exécuter la requête SQL préparée
        $query->execute();

        // Si au moins une ligne ajoutée
        if (1 === $query->rowCount()) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
        }

        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    /**
     * Modification d'un produit dans la BDD
     *
     * @return boolean
     */
    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE en préparé
        $sql = "
            UPDATE `product`
            SET
                `name` = :name, 
                `description` = :description,
                `picture` = :picture,
                `price` = :price,
                `rate` = :rate,
                `status` = :status,
                `brand_id` = :brand_id,
                `category_id` = :category_id,
                `type_id` = :type_id,
                `updated_at` = NOW()
            WHERE `id` = :id;
        ";

        // on prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // liaison des paramètres fictifs
        $pdoStatement->bindValue(":name",           $this->name,            PDO::PARAM_STR);
        $pdoStatement->bindValue(":description",    $this->description,     PDO::PARAM_STR);
        $pdoStatement->bindValue(":picture",        $this->picture,         PDO::PARAM_STR);
        $pdoStatement->bindValue(":price",          $this->price,           PDO::PARAM_STR);
        $pdoStatement->bindValue(":rate",           $this->rate,            PDO::PARAM_INT);
        $pdoStatement->bindValue(":status",         $this->status,          PDO::PARAM_INT);
        $pdoStatement->bindValue(":brand_id",       $this->brand_id,        PDO::PARAM_INT);
        $pdoStatement->bindValue(":category_id",    $this->category_id,     PDO::PARAM_INT);
        $pdoStatement->bindValue(":type_id",        $this->type_id,         PDO::PARAM_INT);
        $pdoStatement->bindValue(":id",             $this->id,              PDO::PARAM_INT);

        // Execution de la requête d'insertion 
        $pdoStatement->execute();

        // Si une ligne modifiée
        if (1 === $pdoStatement->rowCount()) {
            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }
        return false;
    }

    /**
     * Suppression d'un produit dans la base de données
     *
     * @return boolean
     */
    public function delete()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE en préparé
        $sql = "
                DELETE FROM `product`
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
        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        // d'où affichage du message d'erreur
        return false;
    }
    
    /**
     * Récupère la liste des tags pour un produit donné l'objet Product)
     *
     * @return Tags[]
     */
    public function findAllTags(){
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE en préparé
        $sql = "select * 
            from `tag` where id in (
            select tag_id from `product_has_tag` where product_id = :id);";

        
        // on prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // liaison des paramètres fictifs
        $pdoStatement->bindValue(":id",         $this->id,          PDO::PARAM_INT);

        // Execution de la requête d'insertion 
        $pdoStatement->execute();

        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, Tag::class);
        return $results;
    }
}
