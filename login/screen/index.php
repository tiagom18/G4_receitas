<?php include('D:\xampp\htdocs\aulas\G4_receitas\model/conexao.php');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G4_receitas Login</title>
</head>
<body >
    <div class="container" >
        <section>
           <div class="posicao_logo">
               <img src="../images/LOGO-G4-RECEITAS-BRANCO.png ">
           </div>
           <div class="login">
               <div class="txt">
                <span>LOGIN</span>   
                </div>
                <form action="">
                    <div class="">
                        <div class="login_form_quadrado">
                            <label for="email">E-mail</label>
                            <input id="email" name="email" placeholder="Insira seu e-mail" type="email" maxlength="35" value="" required>
                        </div>
                        <div class="login_form_quadrado">
                            <label for="senha">Senha</label>
                            <input id="senha" name="senha" placeholder="Insira sua senha" type="password" maxlength="15" minlength="6" value="" required>
                        </div>  
                    </div>
                    <div class="esqueceu_senha">
                        <a class="link" href="">Esqueci minha senha</a>
                        <button type="submit" id="btn-entrar" class="btn btn-entrar">Entrar</button> 
                    </div>
                </form>
           </div>
           
        </section>
    </div>
</body>
</html>