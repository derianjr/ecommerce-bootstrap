<?php 
include 'config.php';

function logout(){
    session_status();
    session_unset('sistema.php');
    header('Location: login.php');
}

?>