<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../includes/style.css"> 
    <title>Cargo</title>
</head>
<body>
    <?php
        //header
            include ('..\..\includes\header.php');
        //conexão
            include('..\..\model\conexao.php');
    ?>
    <!--Aprensentar dados do cargo selecionado para exclui para o usuário confirmar se realmente quer cancelar-->
    <div class="container" >
        <div class="barra-superior">
            <div class="posicao_logo">
                <img class="logo" src="../../login/images/LOGO-G4-RECEITAS-BRANCO.png">
                <a href="../../login/actions/logout.php"><button class="btn">
                    <img class="btn-img" src="https://i.ibb.co/jG7CH9q/sair-2.png" alt="sair-2" border="0">
                    <span class="btn-txt">Sair</span>
                </button></a>
            </div>
        </div>
    </div>
    
    <?php
        //Ação de confirmação de exclusão
            if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id_Cargo != ""){
                try {
                    $stmt = $conexao->prepare("DELETE FROM g4_cargo WHERE id_Cargo= ?");
                    $stmt->bindParam(1, $id_Cargo, PDO::PARAM_INT); 
                    if($stmt->execute()) {
                        echo "<p>Registro excluido com sucesso!!</p>";
                    } else {
                        echo "<p>Erro: Não foi possível executar a declaração sql</p>";
                    }
                } catch (PDOException $erro) {
                    echo "<p>Erro:".$erro->getMessage()."</p>";
                }
            }
    ?>
</body>
</html>