<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="action/style.css">-->
    <title>Referência</title>
</head>
<?php 
//conexão
include('../model/conexao.php');
//header
include ('../includes/header.php');
//verificando o POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_Referencia = filter_input(INPUT_POST,'id_Referencia');
    $data_inicio = filter_input(INPUT_POST,'data_inicio');
    $data_fim = filter_input(INPUT_POST,'data_inicio');
    $id_Restaurante = filter_input(INPUT_POST,'id_Restaurante');
    $id_Funcionario = filter_input(INPUT_POST,'id_Funcionario');
    
} else if (!isset($id_Referencia)){
    $id_Referencia = (isset($_GET["id_Referencia"]) && $_GET["id_Referencia"] != null) ? $_GET["id_Referencia"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $data_inicio != "") {
    try{
        if ($id_Referencia != "") {
            $stmt = $conexão->prepare("UPDATE g4_referencia SET data_inicio=:data_inicio,data_fim=:data_fim,id_Restaurante=:id_Restaurante,id_Funcionario=:id_Funcionario WHERE id_Referencia = :id_Referencia");
            $stmt->bindParam(":id_Referencia", $id_Referencia);
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_referencia(data_inicio,data_fim,id_Restaurante,id_Funcionario) VALUES (:data_inicio,:data_fim,:id_Restaurante,:id_Funcionario)");
        }
        $stmt->bindParam(":data_inicio", $data_inicio ,PDO::PARAM_STR);
        $stmt->bindParam(":data_fim", $data_fim ,PDO::PARAM_STR);
        $stmt->bindParam(":id_Restaurante", $id_Restaurante ,PDO::PARAM_STR);
        $stmt->bindParam(":id_Funcionario", $id_Funcionario ,PDO::PARAM_STR);
        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<p> Referência cadastrado com sucesso!</p>";
                $id_Referencia = null;
                $data_inicio = null;
                $data_fim = null;
                $id_Restaurante = null;
                $id_Funcionario = null;
            } else {
                echo "<p>Erro no cadastro do Referência</p>";
            }
        } else {
            echo "<p>Erro: Não foi possivel executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro:" .$erro->getMessage(). "</p>";
    }

}

//UPD
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_Referencia != ""){
    try {
        echo "id_Referencia :",  $id;
        $stmt = $conexao->prepare("SELECT data_inicio,data_fim,id_Restaurante,id_Funcionario FROM g4_referencia WHERE id_Referencia= :id");
        $stmt->bindParam(":id", $id_Referencia, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id_Referencia = $rs->$id_Referencia;
            $data_inicio = $rs->$data_inicio;
            $data_fim = $rs->$data_fim;
            $id_Restaurante = $rs->$id_Restaurante;
            $id_Funcionario = $rs->$id_Funcionario;
        } else {
            echo "<p>Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro".$erro->getMessage()."</p>";
    }
}

//pegar as opções do banco 

$sql = " SELECT * FROM g4_restaurante";
try {
    $stmt = $conexao -> prepare($sql);
    $stmt -> execute();
    $results = $stmt -> fetchAll();
}
catch(Exception $ex){
    echo ($ex -> getMessage());

}


$sql = " SELECT * FROM g4_funcionario";
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
        <span class="">Data de incio</span>
        </br>
        <input type="date" name="data_inicio" placeholder="Inserir" value="<?php
        echo (isset($data_inicio) && ($data_inicio != null || $data_inicio != "")) ? $data_inicio : '';
        ?>" class="form-control"/>
        </br>
        <span class="">Data de termino</span>
        </br>
        <input type="date" name="data_fim" placeholder="Inserir" value="<?php
        echo (isset($data_fim) && ($data_fim != null || $data_fim != "")) ? $data_fim : '';
        ?>" class="form-control"/>
        </br>
        </br>
        <select id="id_Restaurante" name="id_Restaurante">
        <option>id do restaurante</option>
        <?php foreach($results as $output) {?>
    <option value="<?php echo $output["id_Restaurante"];?>"><?php echo $output["nome"];?></option>
        <?php } ?>
    </select>
    </br>
    </br>
    <select id="id_Funcionario" name="id_Funcionario">
        <option>id do funcionario</option>
        <?php foreach($results1 as $output) {?>
    <option value="<?php echo $output["id_Funcionario"];?>"><?php echo $output["nome"];?></option>
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
                    <th>Id</th>
                    <th>Data de incio</th>
                    <th>Data de termino</th>
                    <th>id do restaurante</th>
                    <th>id do funcionario</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    try {
                        $stmt = $conexao->prepare("SELECT * FROM g4_referencia");
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>$rs->id_Referencia</td>";
                                echo "<td>$rs->data_inicio</td>";
                                echo "<td>$rs->data_fim</td>";
                                echo "<td>$rs->id_Restaurante</td>";
                                echo "<td>$rs->id_Funcionario</td>";
                                //Alterar 
                                echo '<td><a href="./alterar.php?id='.$rs->id_Referencia.'">Alterar</a></td>';
                                //excluir
                                echo '<td><a href="./excluir.php?id=' .$rs->id_Referencia. '">Excluir</a></td>';
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