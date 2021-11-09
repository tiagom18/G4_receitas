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
    $id_Funcionario = filter_input(INPUT_POST,'id_Funcionario');
    $nome = filter_input(INPUT_POST,'nome');
} else if (!isset($id_Funcionario)){
    $id_Funcionario = (isset($_GET["id_Funcionario"]) && $_GET["id_Funcionario"] != null) ? $_GET["id_Funcionario"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $nome != "") {
    try{
        if ($id_Funcionario != "") {
            $stmt = $conexão->prepare("UPDATE g4_funcionario SET nome=? WHERE id_Funcionario = ?");
            $stmt->bindParam(2, $id_Funcionario);
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_funcionario(nome) VALUES (?)");
        }
        $stmt->bindParam(1, $nome);
        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<p> Cargo cadastrado com sucesso!</p>";
                $id_Funcionario = null;
                $nome = null;
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
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_Funcionario != ""){
    try {
        echo "id_Funcionario :",  $id;
        $stmt = $conexao->prepare("SELECT a.id_Funcionario, a.nome, a.rg, a.data_ingresso, a.nome_fantasia, a.Usuario, a.senha, a.id_Cargo, b.id_Cargo FROM g4_funcionario as a INNER JOIN g4_cargo as b on a.id_Cargo = b.id_Cargo WHERE id_Funcionario= :id");
        $stmt->bindParam(":id", $id_Funcionario, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id_Funcionario = $rs->$id_Funcionario;
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
        <span class="">Cargo</span>
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
                    try {
                        $stmt = $conexao->prepare("SELECT a.id_Funcionario, a.nome, a.rg, a.data_ingresso, a.nome_fantasia, a.Usuario, a.senha, a.id_Cargo, b.id_Cargo FROM g4_funcionario as a INNER JOIN g4_cargo as b on a.id_Cargo = b.id_Cargo");
                         //"SELECT a.id_Funcionario, a.nome, a.rg, a.data_ingresso, a.nome_fantasia, a.Usuario, a.senha b.G4_Cargo_id_Cargo FROM g4_funcionario as a INNER JOIN g4_cargo as b a.G4_Cargo_id_Cargo = b.id_cargo";);
                         //"SELECT a.id_Venda, b.nome, c.id_Horta, a.id_func, a.situacao, a.data_venda FROM mh_venda as a INNER JOIN mh_cliente as b on a.id_Cliente = b.id_Cliente INNER JOIN mh_horta as c on a.id_Horta = c.id_Horta;")
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>$rs->id_Funcionario</td>";
                                echo "<td>$rs->nome</td>";
                                //Alterar 
                                echo '<td><a href="./action/alterar.php?id='.$rs->id_Funcionario.'">Alterar</a></td>';
                                //excluir
                                echo '<td><a href="./action/excluir.php?id=' .$rs->id_Funcionario. '">Excluir</a></td>';
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