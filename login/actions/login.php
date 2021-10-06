<?php
    session_start();

    if(isset($_POST['email'], $_POST['senha'])) {
        if($_POST['email'] == 'admin@horta.com.br' && $_POST['senha'] == '123456') {
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['senha'] = $_POST['senha'];
            header('Location: example.php');
        } else {
            header('Location: ../screen/index.php');
        }
    }
?>