<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet"/>
    <title>Restaurante</title>
</head>
<body>
    <?php
        //header
            include ('../includes/header.php');
        //conexão
            include('../model/conexao.php');
    
        //Aprensentar dados do Restaurante selecionado para exclui para o usuário confirmar se realmente quer cancelar-->
        $id_Restaurante=$_GET["id"];
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
                                <th>Nome do Restaurante</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                try {
                                    $stmt = $conexao->prepare("SELECT * FROM g4_restaurante WHERE id_Restaurante=:id");
                                    $stmt->bindParam(":id", $id_Restaurante, PDO::PARAM_INT);
                                    if ($stmt->execute()) {
                                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                            echo "<tr>";
                                            echo "<td>$rs->id_Restaurante</td>";
                                            echo "<td>$rs->nome</td>";
                                            echo "</tr>";
                                            echo "</br>";
                                            echo "<td>
                                            <button><a href='?act=del&id=".$rs->id_Restaurante."'>Confirmar Exclusão</a></button>
                                            </td>";
                                            echo "<td>
                                            <button><a href='./index.php'>Voltar</a></button>
                                            </td>";
                                        }
                                    } else {
                                    echo "<script> 
                                    alert('IMPOSSIVEL APAGAR CARGO POIS ESTÁ SENDO USADO EM OUTRA PÁGINA!'); 
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
                    if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id_Restaurante != ""){
                        try {
                            $stmt = $conexao->prepare("DELETE FROM g4_restaurante WHERE id_Restaurante= :id");
                            $stmt->bindParam(":id", $id_Restaurante, PDO::PARAM_INT); 
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
                            echo    "<script> 
                                alert('IMPOSSIVEL APAGAR CARGO POIS ESTÁ SENDO USADO EM OUTRA PÁGINA!'); 
                                window.location.href='index.php';  
                                </script>";
                            echo "IMPOSSIVEL APAGAR CARGO POIS ESTÁ SENDO USADO EM OUTRA PÁGINA ";
                        }
                    }
            ?>
        </div>
    </div>
</body>
</html> 
