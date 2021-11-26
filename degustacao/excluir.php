<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet"/>
    <title>Degustação</title>
</head>
<body>
    <?php
        //header
            include ('../includes/header.php');
        //conexão
            include('../model/conexao.php');
    
        //Aprensentar dados do Degustação selecionado para exclui para o usuário confirmar se realmente quer cancelar-->
        $id_Degustacao=$_GET["id"];
    ?>
    <div class="box-p">
        <div class="box-f1">
            <h1>Excluir</h1>
            <div class="box-f3">
                <h2 class="title-02">Consultar</h4>
                <div class="box-f4">
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>nota</th>
                                <th>data_nota</th>
                                <th>id_Funcionario</th>
                                <th>id_Receita</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                try {
                                    $stmt = $conexao->prepare("SELECT * FROM g4_degustacao WHERE id_Degustacao=:id ");
                                    $stmt->bindParam(":id", $id_Degustacao, PDO::PARAM_INT);
                                    if ($stmt->execute()) {
                                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) { 
                                            echo "<tr>";
                                            echo "<td>$rs->id_Degustacao</td>";
                                            echo "<td>$rs->nota</td>";
                                            echo "<td>$rs->data_nota</td>";
                                            echo "<td>$rs->id_Funcionario</td>";
                                            echo "<td>$rs->id_Receita</td>";
                                            echo "</tr>";  
                                             echo "</br>";
                                            echo "<td>
                                            <button><a href='?act=del&id=".$rs->id_Degustacao."'>Confirmar Exclusão</a></button>
                                            </td>";
                                            echo "<td>
                                            <button><a href='./index.php'>Voltar</a></button>
                                            </td>";
                                        }
                                    } else {
                                        echo "<script> 
                                        alert('IMPOSSIVEL APAGAR DEGUSTAÇÃO POIS ESTÁ SENDO USADO EM OUTRA PÁGINA!'); 
                                        window.location.href='index.php';  
                                        </script>";
                                    }
                                } catch (PDOException $erro) {
                                    echo "Erro: " . $erro->getMessage();
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
                // ação de exclusão
                //DEL
                    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id_Degustacao != ""){
                        try {
                            $stmt = $conexao->prepare("DELETE FROM g4_degustacao WHERE id_Degustacao= :id");
                            $stmt->bindParam(":id", $id_Degustacao, PDO::PARAM_INT); 
                            if($stmt->execute()) {
                                echo "<script> 
                                    alert('Registro excluido com sucesso!'); 
                                    window.location.href='index.php';  
                                    </script>";
                                echo "<p>Registro excluido com sucesso!!</p>";
                            } else {
                                echo "<p>Erro: Não foi possível executar a declaração sql</p>";
                            }
                        } catch (PDOException $erro) {
                            echo "IMPOSSIVEL APAGAR DEGUSTAÇÃO POIS ESTÁ SENDO USADO EM OUTRA PÁGINA ";
                        }
                    }
            ?>
        </div>
    </div>
</body>
</html>
