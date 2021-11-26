<?php
require "PHPMailer/PHPMailerAutoload.php";

session_start();
$bdd = new PDO('mysql:host=localhost;dbname=faridt_confirmation;', 'faridt','sC3e4pt46AfPog==');
if(isset($_POST['valider'])){
    if(!empty($_POST['email'])){
        $cle = rand(1000000, 9000000);
        $email = $_POST['email'];
        $insererUser = $bdd->prepare('INSERT INTO users(email, cle, confirme)VALUES(?, ?, ?)');
        $insererUser->execute(array($email, $cle, 0));
        
        $recupUser = $bdd->prepare('SELECT * FROM users where email = ?');
        $recupUser->execute(array($email));
         if($recupUser->rowCount()> 0){
            $userInfos = $recupUser->fetch();
            $_SESSION['id'] = $userInfos['id'];

            function smtpmailer($to, $from, $from_name, $subject, $body)
                    {
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->SMTPAuth = true; 
                
                        $mail->SMTPSecure = 'ssl'; 
                        $mail->Host = 'smtp.gmail.com';
                        $mail->Port = 465;  
                        $mail->Username = 'faridtah97@gmail.com';
                        $mail->Password = 'ENTER YOUR EMAIL PASSWORD';   
                
                //   $path = 'reseller.pdf';
                //   $mail->AddAttachment($path);
                
                        $mail->IsHTML(true);
                        $mail->From="faridtah97@gmail.com";
                        $mail->FromName=$from_name;
                        $mail->Sender=$from;
                        $mail->AddReplyTo($from, $from_name);
                        $mail->Subject = $subject;
                        $mail->Body = $body;
                        $mail->AddAddress($to);

                        if(!$mail->Send())
                        {
                            $error ="Please try Later, Error Occured while Processing...";
                            return $error; 
                        }
                        else 
                        {
                            $error = "Thanks You !! Your email is sent.";  
                            return $error;
                        }
                     
                    }
                    
                    $to   = $_POST['email'];
                    $from = 'faridtah97@gmail.com';
                    $name = 'Farid TAHIRI';
                    $subj = 'Email de confirmation bde compte';
                    $msg = 'http://localhost/loginFormulaireCon/verif.php?id='.$_SESSION['id'].'&cle='.$cle;
                    
                    $error=smtpmailer($to,$from, $name ,$subj, $msg);


         }

    }else{
        echo"veuillez mettre votre email";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insrciption</title>
</head>
<body>
    <form method="POST" action="">
        <input type="email" name="email"><br>
        <input type="submit" name="valider">
    </form>
    
</body>
</html>