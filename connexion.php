<?php
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=faridt_confirmation;', 'faridt','sC3e4pt46AfPog==');
    // $bdd = new PDO('mysql:host=localhost;dbname=confirmation;', 'root','');
    if(isset($_POST['valider'])){
        if(!empty($POST['email'])){
            
            $recupUser = $bdd->prepare('SELECT * FROM users WHERE email = ?');
            $recupUser->excute(array($_POST('email')));
                if($recupUser->rowCount() > 0){
                    $userInfo = $recupUser->fetch();
                    if($userInfo['confirme'] == 1){
                        header('Location: verif.php?id='.$userInfo['id'].'&cle='.$userInfo['cle']);

                    }else{
                        echo"Vous n'êtes pas confirmé au niveau du site";
                    }
                    

                }else{
                    echo"L'utilisateur n'existe pas";
                }
        

        }else{
            echo"Veuillez mettre votre e-mail";
        }
    }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
</head>
<body>
    <form method="POST" action="">
        <input type="email" name="email"><br>
        <input type="submit" name="Envoyer">
    </form>
</body>
</html>