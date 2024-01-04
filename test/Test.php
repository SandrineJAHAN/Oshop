<?php

class Test {
    private $nom;

    protected $router;

    public function __construct($router)
    {
        // chaque fois qu'une nouvelle instance de la classe sera crée, le nom sera initialisé à 'toto'
        // $test = new Test();

        // on peut aussi donner des paramètres à cette méthode
        // $this->nom = $nom;

        // dans le cas de Alto Dispatcher, on pourra transmettre le $router
        $this->router = $router;
    }

    

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }
}
