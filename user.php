<?php

class user
{
    // propriétés 
    //Méthode

    public function inscription($_login, $_prenom, $_nom, $_password, $_password2){
    
        session_start();
        
        include('bdd.php');
        
            $login = htmlspecialchars();
            $prenom = htmlspecialchars();
            $nom = htmlspecialchars();
            $password = sha1();
            $password2 = sha1();
            if (!empty($_POST['login']) && !empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['password']) && !empty($_POST['password2'])) {
                $loginlengh = strlen($login);
                if ($loginlengh <= 255) {
                    $reqlogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
                    $reqlogin->execute(array($login));
                    $loginexist = $reqlogin->rowCount();
                    if ($loginexist == 0) {
                        if ($password == $password2) {
                            $insertutilisateurs = $bdd->prepare("INSERT INTO utilisateurs(login, prenom, nom, password) VALUES(?, ?, ?, ?)");
                            $insertutilisateurs->execute(array($login, $prenom, $nom, $password));
                            $erreur = "* Votre compte a bien été créé <a href=\"connexion.php\">Me connecter</a>";
                        } else {
                            $erreur = "* Vos passwords ne correspondent pas";
                        }
                    } else {
                        $erreur = "* Login déjà utilisé";
                    }
                } else {
                    $erreur = "* Votre login ne doit pas excéder 255 caractères !";
                }
            } else {
                $erreur = "* Tous les champs doivent être complétés";
            }
        }
    
    }