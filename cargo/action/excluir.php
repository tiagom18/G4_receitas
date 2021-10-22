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
    
    <?php 
        // ação de exclusão
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
    ?>
    <br>
    <a href="../cargo/../index.php">Voltar</a>
</body>
</html>