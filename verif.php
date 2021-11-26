<?php
session_start();
// $bdd = new PDO('mysql:host=localhost;dbname=confirmation;', 'root','');
$bdd = new PDO('mysql:host=localhost;dbname=faridt_confirmation;', 'faridt','sC3e4pt46AfPog==');
if (isset($_GET['id']) AND !empty($_GET['id']) AND isset($_GET['cle']) AND  !empty($_GET['cle'])){
    
    $getid = $_GET['id'];
    $getcle = $_GET['cle'];
    $recupUser = $bdd->prepare('SELECT * FROM users WHERE id = ? AND cle = ?');
    $recupUser->excute(array($getid, $getcle));
     if($recupUser->rowCount() > 0){
         $userInfo = $recupUser->fetch();
         if($userInfo['confirme'] != 1){
             $updateConfirmation = $bdd->prepare('UPDATE users SET confirme = ? WHERE id = ?');
             $updateConfirmation->excute(array(1, $getid));
             $_SESSION['cle'] = $getcle;
             header('Location: index.php');
         }else{
             $_SESSION['cle'] = $getcle;
             header('Location: index.php');
         }
     }else{
         echo "Votre clé ou identifiant est incorrect";
     }

}else{
    echo "Aucun utilisateur trouvé";
}



?>