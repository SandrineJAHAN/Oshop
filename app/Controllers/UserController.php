<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends CoreController{

public function add(){

}

public function create(){

}


public function login(){
    $user = new User();
    //dump($user);
    $this->show('user/login', ['user'=> $user]);
}
public function authentify(){
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);
    

    $userModel = new User();
    $user = $userModel->findByEmail($email);
  dump($user);
    
    if ($user) {
        if ($user->getPassword() == $password) {
            echo "connexion reussie";
        } else {
            echo "mauvais mdp ou username";
        }
    } else {
        echo "mauvais mdp ou username";
    }

}
}