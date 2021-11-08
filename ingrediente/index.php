<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="action/style.css">-->
    <title>Cargo</title>
</head>
<?php 
//conexão
include('../model/conexao.php');
//header
include ('..\includes\header.php');
//verificando o POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_Ingrediente = filter_input(INPUT_POST,'id_Ingrediente');
    $descricao = filter_input(INPUT_POST,'descricao');
} else if (!isset($id_Ingrediente)){
    $id_Ingrediente = (isset($_GET["id_Ingrediente"]) && $_GET["id_Ingrediente"] != null) ? $_GET["id_Ingrediente"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $descricao != "") {
    try{
        if ($id_Ingrediente != "") {
            $stmt = $conexão->prepare("UPDATE g4_ingrediente  SET descricao=? WHERE id_Ingrediente = ?");
            $stmt->bindParam(2, $id_Ingrediente);
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_ingrediente (descricao) VALUES (?)");
        }
        $stmt->bindParam(1, $descricao);
        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<p> Cargo cadastrado com sucesso!</p>";
                $id_Ingrediente = null;
                $descricao = null;
            } else {
                echo "<p>Erro no cadastro do cargo</p>";
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

    <form action="?act=save" method="POST" name="form" class="" >
        <span class="">Cargo</span>
        </br>
        <input type="text" name="descricao" placeholder="Inserir" value="<?php
        echo (isset($descricao) && ($descricao != null || $descricao != "")) ? $descricao : '';
        ?>" class="form-control"/>
        </br>
        <button type="submit" class = "">Salvar</button>
        <button type="reset" class = "">Cancelar</button>
        <hr>
    </form>
    
    <!--Fim - Insert form-->
    <!-- Inicio - Read -->
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
                        $stmt = $conexao->prepare("SELECT * FROM g4_ingrediente");
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>$rs->id_Ingrediente</td>";
                                echo "<td>$rs->descricao</td>";
                                //Alterar 
                                echo '<td><a href="./action/alterar.php?id='.$rs->id_Ingrediente.'">Alterar</a></td>';
                                //excluir
                                echo '<td><a href="./action/excluir.php?id=' .$rs->id_Ingrediente. '">Excluir</a></td>';
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