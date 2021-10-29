<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoria</title>
</head>
<?php 
//conexão
include('../model/conexao.php');
//header
include ('..\includes\header.php');
//verificando o POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_Categoria = filter_input(INPUT_POST,'id_Categoria');
    $descricao = filter_input(INPUT_POST,'descricao');
} else if (!isset($id_Categoria)){
    $id_Categoria = (isset($_GET["id_Categoria"]) && $_GET["id_Categoria"] != null) ? $_GET["id_Categoria"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $descricao != "") {
    try{
        if ($id_Categoria != "") {
            $stmt = $conexão->prepare("UPDATE g4_categoria SET descricao=? WHERE id_Categoria = ?");
            $stmt->bindParam(2, $id_Categoria);
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_categoria(descricao) VALUES (?)");
        }
        $stmt->bindParam(1, $descricao);
        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<p> Categoria cadastrada com sucesso!!</p>";
                $id_Categoria = null;
                $descricao = null;
            } else {
                echo "<p>Erro no cadastro do Categoria</p>";
            }
        } else {
            echo "<p>Erro: Não foi possivel executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro:" .$erro->getMessage(). "</p>";
    }

}

//UPD
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_Categoria != ""){
    try {
        $stmt = $conexao->prepare("SELECT * FROM g4_categoria WHERE id_Categoria= :id");
        $stmt->bindParam(":id", $id_Categoria, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id_Categoria = $rs->$id_Categoria;
            $descricao = $rs->$descricao;
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
    <div class="row">
        <div class="panel panel-default">
            <div class="row">
                <form action="?act=save" method="POST" name="form" class="" >
                    <div class="">
                        <div class="">
                            <span class="">Categoria</span>
                        <div class="">
                            <div class="">
                                <label for="descricao" class="">Descrição</label>
                                <div class="">
                                    <input type="text" name="descricao" placeholder="Inserir" value="<?php
                                    echo (isset($descricao) && ($descricao != null || $descricao != "")) ? $descricao : '';
                                    ?>" class="form-control"/>
                                </div>
                                <div>
                                    <button type="submit">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Fim - Insert form-->
    <!-- Inicio - Read -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    try {
                        $stmt = $conexao->prepare("SELECT * FROM g4_categoria");
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>$rs->id_Categoria</td>";
                                echo "<td>$rs->descricao</td>";
                                //Alterar 
                                echo '<td><a href="?act=upd&id='.$rs->id_Categoria.'">Alterar</a></td>';
                                //excluir
                                echo '<td><a href="./action/excluir.php?id=' .$rs->id_Categoria. '">Excluir</a></td>';
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
    <!-- Fim - Read-->
</body>
</html>