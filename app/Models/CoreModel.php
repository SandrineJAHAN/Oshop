<?php

namespace App\Models;

abstract class CoreModel
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;


    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * Méthode générique qui oriente soit sur le update() soit sur le insert()
     *
     * @return boolean
     */
    public function save(){
        if ($this->getId() > 0) {
            // cas d'une mise à jour, on invoque la méthode update() de l'objet courant
            return $this->update();
        } else {
            // cas de la création, on invoque la méthode insert() de l'objet courant
            return $this->insert();
        }
        
    }

    abstract static public function find($id);
    abstract static public function findAll();
    abstract public function insert();
    abstract public function update();
    abstract public function delete();
}
