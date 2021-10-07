<?php include('C:\xampp\htdocs\GitHub\G4_receitas\model\conexao.php');
    session_start();

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
                <form action="../actions/login.php" method="POST">
                    <div class="cont-form">
                        <div class="login_form_quadrado">
                            <label for="funcionario">ID Funcionário</label>
                            <input id="funcionario" name="funcionario" placeholder="Digite seu ID" type="text" maxlength="35" value="" required>
                        </div>
                        <div class="login_form_quadrado1">
                            <label for="senha">Senha</label>
                            <input id="senha" name="senha" placeholder="Digite sua senha" type="password" maxlength="15" minlength="6" value="" required>
                        </div>  
                    </div>
                    <div class="esqueceu_senha">
                        <a class="link" href="">Esqueci minha senha</a>
                        <button type="submit" id="btn-entrar" class="btn-entrar">ENTRAR</button>
                    </div>
                </form>
            </div>
           
        </section>
    </div>
</body>
</html>