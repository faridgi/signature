<?php
session_start();
if(!$SESSION['cle']){
    header('Location : connexion.php');
}

?>