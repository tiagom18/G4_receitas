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
include ('../includes/header.php');
//verificando o POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_Degustacao = filter_input(INPUT_POST,'id_Degustacao');
    $nota = filter_input(INPUT_POST,'nota');
    $data_nota = filter_input(INPUT_POST,'data_nota');
    $id_Funcionario = filter_input(INPUT_POST,'id_Funcionario');
    $id_Receita = filter_input(INPUT_POST,'id_Receita');
} else if (!isset($id_Degustacao)){
    $id_Degustacao = (isset($_GET["id_Degustacao"]) && $_GET["id_Degustacao"] != null) ? $_GET["id_Degustacao"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $nota != "") {
    try{
        if ($id_Degustacao != "") {
            $stmt = $conexão->prepare("UPDATE g4_degustacao SET nota=:nota, data_nota=:data_nota WHERE id_Degustacao = :id_Degustacao");
            $stmt->bindParam(":id_Degustacao", $id_Degustacao);
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_degustacao(nota, data_nota,id_Funcionario,id_Receita) VALUES (:nota,:data_nota,:id_Funcionario,:id_Receita)");
        }
        $stmt->bindParam(":nota", $nota ,PDO::PARAM_STR);
        $stmt->bindParam(":data_nota", $data_nota ,PDO::PARAM_STR);
        $stmt->bindParam(":id_Funcionario", $id_Funcionario ,PDO::PARAM_STR);
        $stmt->bindParam(":id_Receita", $id_Receita ,PDO::PARAM_STR);

        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<script> 
                alert(' Degustação cadastrado com sucesso!'); 
                window.location.href='index.php';  
                </script>";
                $id_Degustacao = null;
                $nota = null;
                $data_nota = null;
                $id_Funcionario = null;
                $id_Receita = null;
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
            $nota = $rs->$nota;
            $data_nota = $data_nota;
            $id_Funcionario = $id_Funcionario;
            $id_Receita = $id_Receita;
        } else {
            echo "<p>Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro".$erro->getMessage()."</p>";
    }
}
$sql = " SELECT * FROM g4_funcionario";
try {
    $stmt = $conexao -> prepare($sql);
    $stmt -> execute();
    $results = $stmt -> fetchAll();
}
catch(Exception $ex){
    echo ($ex -> getMessage());

}
$sql = " SELECT * FROM g4_receita";
try {
    $stmt = $conexao -> prepare($sql);
    $stmt -> execute();
    $results1 = $stmt -> fetchAll();
}
catch(Exception $ex){
    echo ($ex -> getMessage());

}


?>
<body>
    <!--Inicio - Insert form-->

    <form action="?act=save" method="POST" name="form" class="" >
        <span class="">Degustação:</span>
        </br>
        <span class="">NOTA*</span>
        </br>
        <input type="text" name="nota" placeholder="Inserir" value="<?php
        echo (isset($nota) && ($nota != null || $nota != "")) ? $nota : '';
        ?>" class="form-control"/>
        </br>
        <span class="">DATA DA NOTA*</span>
        </br>
        <input type="date" name="data_nota" placeholder="Inserir" value="<?php
        echo (isset($data_nota) && ($data_nota != null || $data_nota != "")) ? $data_nota : '';
        ?>" class="form-control"/>
        </br>
        <span class="">Funcionario*</span>
        </br>
        <select id="id_Funcionario" name="id_Funcionario">
<<<<<<< HEAD
        <option value="" disabled selected>ID Funcinario</option>
=======
<<<<<<< HEAD
        <option value="" disabled selected>ID Funcionario</option>
=======
        <option>ID Funcionario</option>
>>>>>>> fedad53e82c4b0f02d928b12094a19b6f4c463b8
>>>>>>> bf51599f1c7a0db894a3950d518c5edf115d1c32
        <?php foreach($results as $output) {?>
        <option value="<?php echo $output["id_Funcionario"];?>"><?php echo $output["nome"];?></option>
        <?php } ?>
        </select>
        </br>
        <span class="">Receita*</span>
        </br>
        <select id="id_Receita" name="id_Receita">
        <option value="" disabled selected>ID Receita</option>
        <?php foreach($results1 as $output) {?>
        <option value="<?php echo $output["id_Receita"];?>"><?php echo $output["nome"];?></option>
        <?php } ?>
        </select>
        </br>
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
                    <th>ID</th>
                    <th>Nota</th>
                    <th>Data da nota</th>
                    <th>ID do Funcinario</th>
                    <th>ID da Receita</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //f.id_Funcionario, id_cozinheiro, r.nota, d.data-nota, d.nota
                    try {
                        $stmt = $conexao->prepare("SELECT * FROM g4_degustacao");
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>$rs->id_Degustacao</td>";
                                echo "<td>$rs->nota</td>";
                                echo "<td>$rs->data_nota</td>";
                                echo "<td>$rs->id_Funcionario</td>";
                                echo "<td>$rs->id_Receita</td>";
                                //Alterar 
                                echo '<td><a href="./alterar.php?id='.$rs->id_Degustacao.'">Alterar</a></td>';
                                //excluir
                                echo '<td><a href="./excluir.php?id=' .$rs->id_Degustacao. '">Excluir</a></td>';
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