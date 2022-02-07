<?php
require 'user-pdo.php';
if($_POST['submit']){
    $objet = new user;
    $objet->inscription($_POST['login'],$_POST['prenom'],$_POST['nom'],$_POST['password'],$_POST['password2']);
}
?>