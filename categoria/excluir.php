<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/style.css"> 
    <title>Categoria</title>
</head>
<body>
    <?php
        //header
            include ('../includes/header.php');
        //conexão
            include('../model/conexao.php');
    
        //Aprensentar dados do Categoria selecionado para exclui para o usuário confirmar se realmente quer cancelar-->
        $id_Categoria=$_GET["id"];
        ?>
        <h3>Você está tentando excluir:</h3>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Descrição</th>
                </tr>
            </thead>
        <tbody>
            <?php
                try {
                    $stmt = $conexao->prepare("SELECT * FROM g4_categoria WHERE id_Categoria=:id");
                    $stmt->bindParam(":id", $id_Categoria, PDO::PARAM_INT);
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>$rs->id_Categoria</td>";
                            echo "<td>$rs->descricao</td>";
                            echo "</tr>";
                            //excluir
                        echo '<td><a href="?act=del&id='.$rs->id_Categoria.'">Excluir</a></td>';
                        echo "</br>";
                        echo "</tr>";
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
        <?php
        // ação de exclusão
        //DEL
            if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id_Categoria != ""){
                try {
                    $stmt = $conexao->prepare("DELETE FROM g4_categoria WHERE id_Categoria= :id");
                    $stmt->bindParam(":id", $id_Categoria, PDO::PARAM_INT); 
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
                    alert('IMPOSSIVEL APAGAR CATEGORIA POIS ESTÁ SENDO USADO EM OUTRA PÁGINA'); 
                    window.location.href='index.php';  
                    </script>";
                    echo "IMPOSSIVEL APAGAR CATEGORIA POIS ESTÁ SENDO USADO EM OUTRA PÁGINA ";
                }
            }
    ?>
    <br>
    <a href="./index.php">Voltar</a>
</body>
</html>

