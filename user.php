<?php

class user {

    private $id;

    public $login;

    public $password;

    public $email;

    public $firstname;

    public $lastname;

    public function __construct($login,$password,$email,$firstname,$lastname)
    {
        // $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this ->lastname = $lastname;
    }

    public function register($login,$password,$email,$firstname,$lastname)
    {
        $db = mysqli_connect('localhost','root','','classes');

        $req = mysqli_query($db,"INSERT INTO `utilisateurs`(`login`, `password`, `email`, `firstname`, `lastname`) VALUES ('$login','$password','$email','$firstname','$lastname')");

        var_dump($req);

        return $tab = [$login,$email,$firstname,$lastname];






    }

    public function connect($login,$password)
    {
        $db = mysqli_connect('localhost','root','','classes');

        $req_connect = mysqli_query($db,"SELECT * FROM utilisateurs WHERE login = '$login' AND password = '$password'");
        $rows = mysqli_num_rows($req_connect);

        if($rows == 1){
            session_start();
            $_SESSION['login'] = $login;
            echo 'Vous êtes connecté'.$login ;
        }
    }

    public function disconnect()
    {
        session_destroy();
    }

    public function delete($login)
    {
        $db = mysqli_connect('localhost','root','','classes');
        $delete = mysqli_query($db,"DELETE FROM `utilisateurs` WHERE login = '$login'");

        if(isset($_SESSION['login'])){
            session_destroy();
        }

    }

    public function update($login,$password,$mail,$firstname,$lastname)
    {
        $db = mysqli_connect('localhost','root','','classes');
        $update = mysqli_query($db,"UPDATE `utilisateurs` SET `login`='$login',`password`='$password',`email`='$mail',`firstname`='$firstname',`lastname`= '$lastname'");
    }

    public function isconnected()
    {
        if(isset($_SESSION['login'])){
            return true;
        } else {
            return false;
        }
    }

    public function getallinfos()
    {
        $db = mysqli_connect('localhost','root','','classes');
        $infos = mysqli_query($db,"SELECT * FROM `utilisateurs`");
        $u = mysqli_fetch_all($infos);
        foreach($u as $key => $value){
            echo $value[0].' '.$value[1].' '.$value[2].' '.$value[3].' '.$value[4].' '.$value[5].'</br>';
        }
    }

}

$user = new user("","","","","");

// $user->register("John117","Johnny","jonh@hotmlail.com","John","Spartan");

// $user->connect("John117","Johnny");

$user->getallinfos();


