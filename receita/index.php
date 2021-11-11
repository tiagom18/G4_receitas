<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="action/style.css">-->
    <title>Receita</title>
</head>
<?php 
//conexão
include('../model/conexao.php');
//header
include ('../includes/header.php');
//verificando o POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_cozinheiro = filter_input(INPUT_POST,'id_cozinheiro');
    $nome = filter_input(INPUT_POST,'nome');
} else if (!isset($id_cozinheiro)){
    $id_cozinheiro = (isset($_GET["id_cozinheiro"]) && $_GET["id_cozinheiro"] != null) ? $_GET["id_cozinheiro"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $nome != "") {
    try{
        if ($id_cozinheiro != "") {
            $stmt = $conexão->prepare("UPDATE g4_receita SET nome=:nome, id_receita=:id_receita, data_criacao=:data_criacao, qtde_porcao=:qtde_porcao, ind_receita_inedita=:ind_receita_inedita, id_Categoria=:id_Categoria, id_Funcionario=:id_Funcionario   WHERE id_cozinheiro = :id_cozinheiro");
            $stmt->bindParam(":id_cozinheiro", $id_cozinheiro);
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_receita(nome, id_receita, data_criacao, qtde_porcao, ind_receita_inedita, id_Categoria, id_Funcionario) 
            VALUES (:nome,:id_receita,:data_criacao,:qtde_porcao,:ind_receita_inedita,:id_Categoria,:id_Funcionario)");
        }
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":id_cozinheiro", $id_cozinheiro);
        $stmt->bindParam(":data_criacao", $data_criacao);
        $stmt->bindParam(":modo_preparo", $modo_preparo);
        $stmt->bindParam(":qtde_porcao", $qtde_porcao);
        $stmt->bindParam(":ind_receita_inedita", $ind_receita_inedita);
        $stmt->bindParam(":id_Categoria", $id_Categoria);
        $stmt->bindParam(":id_Funcionario", $id_Funcionario);

        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<p> Receita cadastrado com sucesso!</p>";
                $id_receita = null;
                $nome = null;
                $id_cozinheiro = null;
                $data_criacao = null;
                $modo_preparo = null;
                $qtde_porcao = null;
                $ind_receita_inedita = null;
                $id_Categoria  = null;
                $id_Funcionario  = null;
            } else {
                echo "<p>Erro no cadastro do Receita</p>";
            }
        } else {
            echo "<p>Erro: Não foi possivel executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro:" .$erro->getMessage(). "</p>";
    }

}

//UPD

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_cozinheiro != ""){
    try {
        echo "id_cozinheiro :",  $id;
        $stmt = $conexao->prepare("SELECT id_cozinheiro, id_receita, nome, data_criacao, modo_preparo, qtde_porcao, ind_receita_inedita,id_Categoria,id_Funcionario FROM g4_receita WHERE id_cozinheiro= :id");
       
        $stmt->bindParam(":id", $id_cozinheiro, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id_cozinheiro = $rs->id_cozinheiro;
            $id_receita = $rs->$id_receita;
            $nome = $rs->$nome;
            $data_criacao = $rs->$data_criacao;
            $modo_preparo = $rs->$modo_preparo;
            $qtde_porcao = $rs->$qtde_porcao;
            $ind_receita_inedita = $rs->$ind_receita_inedita;
            $id_Categoria = $rs->$id_Categoria;
            $id_Funcionario = $rs->$id_Funcionario;
           
           
            

        } else {
            echo "<p>Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro".$erro->getMessage()."</p>";
    }
}

//pegar as opções do banco 


// perguntar pra ana como fazer o g4_categoria funcionar
$sql = " SELECT * FROM g4_funcionario ";
try {
    $stmt = $conexao -> prepare($sql);
    $stmt -> execute();
    $results = $stmt -> fetchAll();
}
catch(Exception $ex){
    echo ($ex -> getMessage());

}


?>
<body>
    <!--Inicio - Insert form-->

    <form action="?act=save" method="POST" name="form" class="" >
        <span class="">Receita</span>
        </br>
        <input type="text" name="nome" placeholder="Inserir" value="<?php
        echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
        ?>" class="form-control"/>
        </br>
        <span class="">ID Receita</span>
        </br>
        <input type="text" name="id_receita" placeholder="Inserir" value="<?php
        echo (isset($id_receita) && ($id_receita != null || $id_receita != "")) ? $id_receita : '';
        ?>" class="form-control"/>
        </br>
        <span class="">Data de criação</span>
        </br>
        <input type="date" name="data_criacao" placeholder="Inserir" value="<?php
        echo (isset($data_criacao) && ($data_criacao != null || $data_criacao != "")) ? $data_criacao : '';
        ?>" class="form-control"/>
        </br>
        <span class="">Modo de preparo</span>
        </br>
        <input type="text" name="modo_preparo" placeholder="Inserir" value="<?php
        echo (isset($modo_preparo) && ($modo_preparo != null || $modo_preparo != "")) ? $modo_preparo : '';
        ?>" class="form-control"/>
        </br>
        <span class="">Qtde por porção</span>
        </br>
        <input type="text" name="qtde_porcao" placeholder="Inserir" value="<?php
        echo (isset($qtde_porcao) && ($qtde_porcao != null || $qtde_porcao != "")) ? $qtde_porcao : '';
        ?>" class="form-control"/>
        </br>
        <span class="">Receita inedita</span>
        </br>
        <input type="text" name="ind_receita_inedita" placeholder="Inserir" value="<?php
        echo (isset($ind_receita_inedita) && ($ind_receita_inedita != null || $ind_receita_inedita != "")) ? $ind_receita_inedita : '';
        ?>" class="form-control"/>
        </br>
        </br>
        <select id="id_Categoria" name="id_Categoria">
            <option>Categoria</option>
                <?php foreach($results as $output) {?>
            <option value="<?php echo $output["id_Categoria"];?>"><?php echo $output["nome"];?></option>
        <?php } ?>
        </select>
        </br>
        </br>
        <select id="id_Funcionario" name="id_Funcionario">
            <option>Funcinario</option>
                <?php foreach($results as $output) {?>
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
                    <th>Nome</th>
                    <th>ID Receita</th>
                    <th>Data de criação</th>
                    <th>Modo de preparo</th>
                    <th>Qtde por porção</th>
                    <th>Receita inedita</th>
                    <th>ID Categoria</th>
                    <th>imagem</th>
                    <th>Id_funcionario</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                    try {
                        $stmt = $conexao->prepare("SELECT * FROM g4_receita");
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>$rs->id_cozinheiro</td>";
                                echo "<td>$rs->nome</td>";
                                echo "<td>$rs->id_receita</td>";
                                echo "<td>$rs->data_criacao</td>";
                                echo "<td>$rs->modo_preparo</td>";
                                echo "<td>$rs->qtde_porcao</td>";
                                echo "<td>$rs->ind_receita_inedita</td>";
                                echo "<td>$rs->id_Categoria</td>";
                                echo "<td>$rs->id_Funcionario</td>";
                               
           
                                //Alterar 
                                echo '<td><a href="./alterar.php?id='.$rs->id_cozinheiro.'">Alterar</a></td>';
                                //excluir
                                echo '<td><a href="./excluir.php?id=' .$rs->id_cozinheiro. '">Excluir</a></td>';
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