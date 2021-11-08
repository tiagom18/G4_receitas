<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../includes/style.css"> 
    <title>Medida</title>
</head>
<body>
    <?php
        //header
            include ('..\..\includes\header.php');
        //conexão
            include('..\..\model\conexao.php');
    
        //Aprensentar dados do Medida selecionado para exclui para o usuário confirmar se realmente quer cancelar-->
        $id_Medida=$_GET["id"];
        try {
            $stmt = $conexao->prepare("SELECT * FROM g4_medida WHERE id_Medida= :id");
            $stmt->bindParam(":id", $id_Medida, PDO::PARAM_INT); 
            if ($stmt->execute()) {
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    echo "<tr>";
                    echo "<td>$rs->id_Medida</td>";
                    echo "<td>$rs->descricao</td>";
                    echo "<br>";
                    //excluir
                    echo '<td><a href="?act=del&id='.$rs->id_Medida.'">Excluir</a></td>';
                    echo "</tr>";
                }
            } else {
           echo "Erro: Não foi possível recuperar os dados do banco de dados";
            }
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
        // ação de exclusão
        //DEL
            if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id_Medida != ""){
                try {
                    $stmt = $conexao->prepare("DELETE FROM g4_medida WHERE id_Medida= :id");
                    $stmt->bindParam(":id", $id_Medida, PDO::PARAM_INT); 
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
    <br>
    <a href="../Medida/../index.php">Voltar</a>
</body>
</html>