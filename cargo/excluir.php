<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet"/>
    <title>Cargo</title>
</head>
<body>
    <?php
        //header
            include ('../includes/header.php');
        //conexão
            include('../model/conexao.php');
    
        //Aprensentar dados do cargo selecionado para exclui para o usuário confirmar se realmente quer cancelar-->
        $id_Cargo=$_GET["id"];
        try {
            $stmt = $conexao->prepare("SELECT * FROM g4_cargo WHERE id_Cargo= :id");
            $stmt->bindParam(":id", $id_Cargo, PDO::PARAM_INT); 
            if ($stmt->execute()) {
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    echo "<div class=acao_excluir>";
                    echo "<div class=acao_tamanho>";
                    echo "<p class='title_excluir'> VOCÊ ESTÁ TENTANDO EXCLUIR:</p>";
                    echo "<div class=box-f4>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th> ID</th>";
                    echo "<th> Descrição</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    echo "<tr>";
                    echo "<td>$rs->id_Cargo</td>";
                    echo "<td>$rs->nome</td>";
                    //excluir          
                    echo '<td><a href="?act=del&id='.$rs->id_Cargo.'">Excluir</a></td>';
                    echo "</tr>";
                    echo "</tbody>";
                    echo "</div>";
                }
            } else {
           echo "Erro: Não foi possível recuperar os dados do banco de dados";
            }
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
    ?>
        <a href="./index.php">Voltar</a>
        </div>
    </div>
    <?php
        // ação de exclusão
        //DEL
            if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id_Cargo != ""){
                try {
                    $stmt = $conexao->prepare("DELETE FROM g4_cargo WHERE id_Cargo= :id");
                    $stmt->bindParam(":id", $id_Cargo, PDO::PARAM_INT); 
                    if($stmt->execute()) {
                        echo "<script> 
                            alert('Registro excluido com sucesso!'); 
                            window.location.href='index.php';  
                            </script>";
                        echo "<p class = 'txt_cargo_exlcuido'> Registro excluido com sucesso!</p>";
                    } else {
                        echo "<p>Erro: Não foi possível executar a declaração sql</p>";
                    }
                } catch (PDOException $erro) {
                    echo "<script> 
                        alert('IMPOSSIVEL APAGAR CARGO POIS ESTÁ SENDO USADO EM OUTRA PÁGINA'); 
                        window.location.href='index.php';  
                        </script>";
                    echo "IMPOSSIVEL APAGAR CARGO POIS ESTÁ SENDO USADO EM OUTRA PÁGINA ";
            
                }
            }
    ?>
</body>
</html>