<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="action/style.css">-->
    <title>Degustação</title>
</head>
<?php 
//conexão
include('../model/conexao.php');
//header
include ('..\includes\header.php');
//verificando o POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_Degustacao = filter_input(INPUT_POST,'id_Degustacao');
    $nome = filter_input(INPUT_POST,'nome');
} else if (!isset($id_Degustacao)){
    $id_Degustacao = (isset($_GET["id_Degustacao"]) && $_GET["id_Degustacao"] != null) ? $_GET["id_Degustacao"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $nome != "") {
    try{
        if ($id_Degustacao != "") {
            $stmt = $conexão->prepare("UPDATE g4_degustacao SET nome=? WHERE id_Degustacao = ?");
            $stmt->bindParam(2, $id_Degustacao);
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_degustacao(nome) VALUES (?)");
        }
        $stmt->bindParam(1, $nome);
        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<p> Degustação cadastrado com sucesso!</p>";
                $id_Degustacao = null;
                $nome = null;
            } else {
                echo "<p>Erro no cadastro do Degustação</p>";
            }
        } else {
            echo "<p>Erro: Não foi possivel executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro:" .$erro->getMessage(). "</p>";
    }

}

//UPD
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_Degustacao != ""){
    try {
        echo "id_Degustacao :",  $id;
        $stmt = $conexao->prepare("SELECT * FROM g4_degustacao WHERE id_Degustacao= :id");
        $stmt->bindParam(":id", $id_Degustacao, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id_Degustacao = $rs->$id_Degustacao;
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

    <form action="?act=save" method="POST" name="form" class="" >
        <span class="">Degustação</span>
        </br>
        <input type="text" name="nome" placeholder="Inserir" value="<?php
        echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
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
                    //f.id_Funcionario, id_cozinheiro, r.nome, d.data-nota, d.nota
                    try {
                        $stmt = $conexao->prepare("SELECT  FROM g4_degustacao");
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>$rs->id_Degustacao</td>";
                                echo "<td>$rs->nome</td>";
                                //Alterar 
                                echo '<td><a href="./action/alterar.php?id='.$rs->id_Degustacao.'">Alterar</a></td>';
                                //excluir
                                echo '<td><a href="./action/excluir.php?id=' .$rs->id_Degustacao. '">Excluir</a></td>';
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