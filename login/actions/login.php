<?php
    session_start();

    if(isset($_POST['funcionario'], $_POST['senha'])) {
        if($_POST['funcionario'] == '123456' && $_POST['senha'] == '123456') {
            $_SESSION['funcionario'] = $_POST['funcionario'];
            $_SESSION['senha'] = $_POST['senha'];
            header('Location: ../../inicio/index.php');
        } else {
            header('Location: ../screen/index.php');
        }
    }
?>