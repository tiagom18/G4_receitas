<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>receita</title>
</head>
<?php 
//conexão
include('../model/conexao.php');
//header
include ('..\includes\header.php');
//verificando o POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_receita = filter_input(INPUT_POST,'id_receita');
    $nome = filter_input(INPUT_POST,'nome');
} else if (!isset($id_receita)){
    $id_receita = (isset($_GET["id_receita"]) && $_GET["id_receita"] != null) ? $_GET["id_receita"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $nome != "") {
    try{
        if ($id_receita != "") {
            $stmt = $conexão->prepare("UPDATE g4_receita SET nome=? WHERE id_receita = ?");
            $stmt->bindParam(2, $id_receita);
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_receita(nome) VALUES (?)");
        }
        $stmt->bindParam(1, $nome);
        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<p> receita cadastrada com sucesso!!</p>";
                $id_receita = null;
                $nome = null;
            } else {
                echo "<p>Erro no cadastro do receita</p>";
            }
        } else {
            echo "<p>Erro: Não foi possivel executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro:" .$erro->getMessage(). "</p>";
    }

}

//UPD
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_receita != ""){
    try {
        $stmt = $conexao->prepare("SELECT * FROM g4_receita WHERE id_receita= :id");
        $stmt->bindParam(":id", $id_receita, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id_receita = $rs->$id_receita;
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
    <div class="row">
        <div class="panel panel-default">
            <div class="row">
                <form action="?act=save" method="POST" name="form" class="" >
                    <div class="">
                        <div class="">
                            <span class="">receita</span>
                        <div class="">
                            <div class="">
                                <label for="nome" class="">Descrição</label>
                                <div class="">
                                    <input type="text" name="nome" placeholder="Inserir" value="<?php
                                    echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
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
                        $stmt = $conexao->prepare("SELECT * FROM g4_receita");
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>$rs->id_receita</td>";
                                echo "<td>$rs->nome</td>";
                                //Alterar 
                                echo '<td><a href="?act=upd&id='.$rs->id_receita.'">Alterar</a></td>';
                                //excluir
                                echo '<td><a href="./action/excluir.php?id=' .$rs->id_receita. '">Excluir</a></td>';
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