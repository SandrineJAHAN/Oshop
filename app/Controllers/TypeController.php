<?php

namespace App\Controllers;

use App\Models\Type;

class TypeController extends CoreController{

    protected $id;
    protected $name;
    protected $created_at;
    protected $updated_at;

    // méthode pour afficher la list de type
    public function list(){

        $types = Type::findAll();
        // Afficher la vue des lists
        $this->show("type/list", ['types'=>$types]);
    }

    // méthodes pour afficher la page d'ajout de type
    public function add(){
        $type = new Type();

        $this->show('type/addUpdate', ['type'=>$type]);

    }

    public function create(){

        $name = htmlspecialchars(filter_input(INPUT_POST, "name"));

        // on crée un instance de type
        $type = new Type();
        // on l'hydrate 
        $type->setName($name);


        if($type->insert()) {
            header("Location: " . $this->router->generate("type-list"));
            exit;
        } else {
            echo("problème lors de l'enregistrement");
        }
       
    }

    public function edit($id)
    {
        // on récupère la catégorie $id
        $type = Type::find($id);
        // on apelle la vue
        $this->show("type/addUpdate", ['type'=>$type]);
    }

    public function update($id){
        // echo "entree dans la function update de category";
         $category = Type::find($id);
          // on filtre les entrées pour éviter les injections SQL et s'assurer de la qulité des données fournies par l'utilisateur
          $name = htmlspecialchars(filter_input(INPUT_POST, "name"));
                
        
          
         // on l'hydrate
         $category->setName($name);
           
         
         if($category->update()) {
 
             header("Location: " . $this->router->generate("type-list"));
             exit;
         } else {
             echo("problème lors de l'enregistrement");
         }

    
    
 
     }
     public function delete($id){
        $category = Type::find($id);
        $category->delete();
        
        header("Location: " . $this->router->generate("category-list"));

        
    }
     
}

