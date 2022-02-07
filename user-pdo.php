<?php
        session_start();

class user
{

    // propriétés 
    //Méthode(s)

    private $id;

    public $login;

    public $password;

    public $prenom;

    public $nom;


    public $_bdd = new PDO('mysql:host=localhost;dbname=classes', 'root', '');

    public function inscription($_login, $_prenom, $_nom, $_password, $_password2){

        $this->_bdd;
        
        
            $login = htmlspecialchars($_login);
            $prenom = htmlspecialchars($_prenom);
            $nom = htmlspecialchars($_nom);
            $password = sha1($_password);
            $password2 = sha1($_password);
            if (!empty($_POST[$login]) && !empty($_POST[$prenom]) && !empty($_POST[$nom]) && !empty($_POST[$password]) && !empty($_POST[$password2])) {
                $loginlengh = strlen($login);
                if ($loginlengh <= 255) {
                    $reqlogin = $this->_bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
                    $reqlogin->execute(array($login));
                    $loginexist = $reqlogin->rowCount();
                    if ($loginexist == 0) {
                        if ($password == $password2) {
                            $insertutilisateurs = $this->_bdd->prepare("INSERT INTO utilisateurs(login, prenom, nom, password) VALUES(?, ?, ?, ?)");
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

        public function connexion($_login, $_prenom, $_nom, $_password){
        $login = htmlspecialchars($_POST[$_login]);
        $password = sha1($_POST[$_password]);
        if (!empty($login) && !empty($password)) {
            $requser = $this->_bdd->prepare("SELECT * FROM utilisateurs WHERE login = ? && password= ? ");
            $requser->execute(array($login, $password));
            $userexist = $requser->rowCount();
            if ($userexist == 1) {
                $userinfo = $requser->fetch();
                $_SESSION['id'] = $userinfo['id'];
                $_SESSION['login'] = $userinfo['login'];
                $_SESSION['prenom'] = $userinfo['prenom'];
                $_SESSION['nom'] = $userinfo['nom'];
                header("Location: profil.php?id=" . $_SESSION['id']);
            }
            if ($_login == "admin" && $_password == "admin") {
                $_SESSION['admin'] = 1;
                header("Location: admin.php");
            } else {
                $erreur = "* Login inexistant ou password incorrect ";
            }
        } else {
            $erreur = "* Tous les champs doivent être complétés";
        }

        }

        public function isConnected(){
            if(isset($_SESSION['id'])){
                return true;
            }
            else{
                return false;
            }
        } 


public function disconnect()
{
    session_destroy();
}

public function delete($login)
{
try{
           $_bdd = new PDO ('mysql:host=localhost;dbname=classes','root','');
       } catch(PDOexception $e){
           echo "une erreur est survenue";
       }

       $delete = $_bdd->query("DELETE FROM `utilisateurs` WHERE login = '$login'");

       if(isset($_SESSION['login'])){
           session_destroy();
       }

   }

   public function update($login,$password,$prenom,$nom)
   {   
       try{
           $_bdd = new PDO ('mysql:host=localhost;dbname=classes','root','');
       } catch(PDOexception $e){
           echo "une erreur est survenue";
       }

       $update =$_bdd->query("UPDATE `utilisateurs` SET `login`='$login',`password`='$password',`prenom`='$prenom',`nom`= '$nom'");
   }

   public function getallinfos()
   {
       try{
           $_bdd = new PDO ('mysql:host=localhost;dbname=classes','root','');
       } catch(PDOexception $e){
           echo "une erreur est survenue";
       }

       $infos =$_bdd-> prepare("SELECT * FROM `utilisateurs`");
       $infos->execute();
       $u = $infos->fetchAll(PDO::FETCH_ASSOC);


       foreach($u as $key => $value){
           echo $value['id'].' '.$value['login'].' '.$value['password'].' '.$value['prenom'].' '.$value['nom'].'</br>';
   }
   }

}
?>