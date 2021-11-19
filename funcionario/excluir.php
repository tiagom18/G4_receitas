<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet"/>
    <title>Funcinario</title>
</head>
<body>
    <?php
        //header
            include ('../includes/header.php');
        //conexão
            include('../model/conexao.php');
    
        //Aprensentar dados do cargo selecionado para exclui para o usuário confirmar se realmente quer cancelar-->
        $id_Funcionario=$_GET["id"];
    ?>
    <div class="box-p">
        <div class="box-f1">
            <h1>Você está tentando excluir</h1>
            <div class="box-f3">
                <h2 class="title-02">Consultar</h4>
                <div class="box-f4">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>RG</th>
                                <th>Data de ingresso</th>
                                <th>Nome fantasia</th>
                                <th>Usuário</th>
                                <th>Senha</th>
                                <th>Cargo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                try {
                                    $stmt = $conexao->prepare("SELECT a.id_Funcionario, a.nome, a.rg, a.data_ingresso, a.nome_fantasia, a.usuario, a.senha, b.id_Cargo FROM g4_funcionario as a INNER JOIN g4_cargo as b on a.id_Cargo = b.id_Cargo WHERE id_Funcionario=:id");
                                    $stmt->bindParam(":id", $id_Funcionario, PDO::PARAM_INT);
                                    if ($stmt->execute()) {
                                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                            echo "<tr>";
                                            echo "<td>$rs->id_Funcionario</td>";
                                            echo "<td>$rs->nome</td>";
                                            echo "<td>$rs->rg</td>";
                                            echo "<td>$rs->data_ingresso</td>";
                                            echo "<td>$rs->nome_fantasia</td>";
                                            echo "<td>$rs->usuario</td>";
                                            echo "<td>$rs->senha</td>";
                                            echo "<td>$rs->id_Cargo</td>";
                                            //excluir
                                            echo "<td>
                                            <button><a href='?act=del&id=".$rs->id_Funcionario."'>Confirmar Exclusão</a></button>
                                            </td>";
                                            echo "<td>
                                            <button><a href='./index.php'>Voltar</a></button>
                                            </td>";
                                        }
                                    } else {
                                    echo "Erro: Não foi possível recuperar os dados do banco de dados";
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
                    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id_Funcionario != ""){
                        try {
                            $stmt = $conexao->prepare("DELETE FROM g4_funcionario WHERE id_Funcionario= :id");
                            $stmt->bindParam(":id", $id_Funcionario, PDO::PARAM_INT); 
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
                            echo "<script> 
                                alert('IMPOSSIVEL APAGAR FUNCIONARIO POIS ESTÁ SENDO USADO EM OUTRA PÁGINA'); 
                                window.location.href='index.php';  
                                </script>";
                            echo "<script> 
                                alert('IMPOSSIVEL APAGAR CARGO POIS ESTÁ SENDO USADO EM OUTRA PÁGINA!'); 
                                window.location.href='index.php';  
                                </script>";
                        }
                    }
            ?>
        </div>
    </div>                    
</body>
</html>