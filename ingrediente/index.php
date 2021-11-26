<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet"/>
    <title>Ingrediente</title>
</head>
<?php 
//conexão
include('../model/conexao.php');
//header
include ('../includes/header.php');
//verificando o POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_Ingrediente = filter_input(INPUT_POST,'id_Ingrediente');
    $descricao = filter_input(INPUT_POST,'descricao');
    $nome = filter_input(INPUT_POST,'nome');
} else if (!isset($id_Ingrediente)){
    $id_Ingrediente = (isset($_GET["id_Ingrediente"]) && $_GET["id_Ingrediente"] != null) ? $_GET["id_Ingrediente"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $descricao != "") {
    try{
        if ($id_Ingrediente != "") {
            $stmt = $conexão->prepare("UPDATE g4_ingrediente  SET descricao=:descricao, nome=:nome WHERE id_Ingrediente = :id_Ingrediente");
            $stmt->bindParam(":id_Ingrediente", $id_Ingrediente);
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_ingrediente (descricao, nome) VALUES (:descricao,:nome)");
        }
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":nome", $nome);
        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<script> 
                alert(' Ingrediente cadastrado com sucesso!'); 
                window.location.href='index.php';  
                </script>";
                echo "<p> Ingrediente cadastrado com sucesso!</p>";
                $id_Ingrediente = null;
                $descricao = null;
                $nome = null;
            } else {
                echo "<p>Erro no cadastro do Ingrediente</p>";
            }
        } else {
            echo "<p>Erro: Não foi possivel executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro:" .$erro->getMessage(). "</p>";
    }

}

//UPD
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_Ingrediente != ""){
    try {
        echo "id_Ingrediente :",  $id;
        $stmt = $conexao->prepare("SELECT * FROM g4_ingrediente  WHERE id_Ingrediente= :id");
        $stmt->bindParam(":id", $id_Ingrediente, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id_Ingrediente = $rs->$id_Ingrediente;
            $descricao = $rs->$descricao;
            $nome = $rs->$nome;
        } else {
            echo "<p>Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro".$erro->getMessage()."</p>";
    }
}


?>
<body>
    <!--Inicio - Insert form-->
    <div class="box-p">
        <div class="box-f1">
            <div class="box-f2">
                <h1>Ingrediente</h1>
                <h2 class="title-01">Incluir</h2>
                <form action="?act=save" method="POST" name="form" class="" >
                    <div class="grid">
                        <div>
                            <span class="Nome">Nome*</span>
                            <input required type="text" name="nome" placeholder="Inserir" value="<?php
                            echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
                            ?>" class="form-control"/>
                        </div>
                        <div>
                            <span class="Descricao">Descrição*</span>
                            <input required type="text" name="descricao" placeholder="Inserir" value="<?php
                            echo (isset($descricao) && ($descricao != null || $descricao != "")) ? $descricao : '';
                            ?>" class="form-control"/>
                        </div>
                        <div class="box-btn">
                            <button type="reset" class = "">Cancelar</button>
                            <button type="submit" class = "">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
    
        <!--Fim - Insert form-->
        <!-- Inicio - Read -->
        <div class="box-f3">
                <h2 class="title-02">Consultar</h4>
                <div class="box-f4">
                    <div class="scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>   
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    try {
                                        $stmt = $conexao->prepare("SELECT * FROM g4_ingrediente");
                                        if ($stmt->execute()) {
                                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                echo "<tr>";
                                                echo "<td>$rs->id_Ingrediente</td>";
                                                echo "<td>$rs->nome</td>";
                                                echo "<td>$rs->descricao</td>";
                                                //Alterar 
                                                echo '<td><a href="./alterar.php?id='.$rs->id_Ingrediente.'">Alterar</a></td>';
                                                //excluir
                                                echo '<td><a href="./excluir.php?id=' .$rs->id_Ingrediente. '">Excluir</a></td>';
                                                echo "</tr>";
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
            </div>
        </div>
    </div>
    <!-- Fim - Read-->
    </div>
</body>
</html>