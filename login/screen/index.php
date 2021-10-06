<?php include('../model/conexao.php');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horta Comunitária - Login</title>
</head>
<body>
    <div class="container">
        <section>
            <div class="cont1">
                <div class="bg-green"></div>
                <div class="bg-image"></div>
            </div>
            <div class="cont2">
                <div class="block">
                    <div class="cont-logo">
                        <img src="https://www.imagemhost.com.br/images/2021/09/15/logo.png" alt="logo.png" border="0">
                        <div>
                            <img src="https://www.imagemhost.com.br/images/2021/09/15/lock.png" alt="lock.png" border="0">
                            <div>
                                <p>Login exclusivo para os funcionários da empresa</p>
                            </div>
                        </div>
                    </div>
                    <div class="cont-title">
                        <p>Acesse sua conta</p>
                    </div>
                    <form action="../actions/login.php" method="POST">
                        <div class="cont-form">
                            <label for="email">E-mail</label>
                            <input id="email" name="email" placeholder="Insira seu e-mail" type="email" maxlength="35" value="" required>
                        </div>
                        <div class="cont-form">
                            <label for="senha">Senha</label>
                            <input id="senha" name="senha" placeholder="Insira sua senha" type="password" maxlength="15" minlength="6" value="" required>
                        </div>
                        <div class="cont-options">
                            <label class="conectado">
                                Manter conectado
                                <input type="checkbox" value="conectado" checked>
                                <span class="checkmark"></span>
                            </label>
                            <a class="link" href="">Esqueceu sua senha?</a>
                        </div>
                        <button type="submit" id="btn-entrar" class="btn btn-entrar">Entrar</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</body>
</html>