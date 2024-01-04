<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Tag extends CoreModel
{

    /**
     * @var string
     */
    private $name;


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
     * Méthode permettant de récupérer un enregistrement de la table Tag en fonction d'un id donné
     *
     * @param int $id ID de la catégorie
     * @return Tag
     */
    static public function find($id)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `tag` WHERE `id` =' . $id;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        $tag = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $tag;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table tag
     *
     * @return Tag[]
     */
    static public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `tag`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Tag');

        return $results;
    }

     /**
     * Méthode permettant d'ajouter un enregistrement dans la table tag
     *
     * @return bool
     */
    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();


        // écriture de la requête préparée utilisant des paramêtres fictifs
        $sql = "
            INSERT INTO `tag` (name)
            VALUES ( :name);
                ";

        // on prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // liaison des paramètres fictifs
        $pdoStatement->bindValue(":name",       $this->name,        PDO::PARAM_STR);

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
        UPDATE `tag`
        SET name=:name
        WHERE id=:id; 
        ";

        // on prépare la requête
        $pdoStatement = $pdo->prepare($sql);

        // liaison des paramètres fictifs
        $pdoStatement->bindValue(":name",       $this->name,        PDO::PARAM_STR);
        $pdoStatement->bindValue(":id",         $this->id,          PDO::PARAM_INT);

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
                DELETE FROM `tag` WHERE id=:id;
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
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }
        // si on arrive ici, c'est que quelque chose c'est mal passé
        return false;
    }
}
