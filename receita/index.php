<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet"/>
    <title>Receita</title>
</head>
<?php 
//conexão
include('../model/conexao.php');
//header
include ('../includes/header.php');
//verificando o POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_Receita = filter_input(INPUT_POST,'id_Receita');
    $nome = filter_input(INPUT_POST,'nome');
    $data_criacao = filter_input(INPUT_POST,'data_criacao');
    $modo_preparo = filter_input(INPUT_POST,'modo_preparo');
    $qtde_porcao = filter_input(INPUT_POST,'qtde_porcao');
    $id_Categoria = filter_input(INPUT_POST,'id_Categoria');
    $id_Funcionario = filter_input(INPUT_POST,'id_Funcionario');
} else if (!isset($id_Receita)){
    $id_Receita = (isset($_GET["id_Receita"]) && $_GET["id_Receita"] != null) ? $_GET["id_Receita"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $nome != "") {
    try{
        if ($id_Receita != "") {
            $stmt = $conexão->prepare("UPDATE g4_receita SET nome=:nome, id_receita=:id_receita, data_criacao=:data_criacao, qtde_porcao=:qtde_porcao, id_Categoria=:id_Categoria, id_Funcionario=:id_Funcionario   WHERE id_Receita = :id_Receita");
            $stmt->bindParam(":id_Receita", $id_Receita);
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_receita(nome, id_receita, data_criacao,modo_preparo, qtde_porcao, id_Categoria, id_Funcionario) 
            VALUES (:nome,:id_receita,:data_criacao,:modo_preparo,:qtde_porcao,:id_Categoria,:id_Funcionario)");
        }
        $stmt->bindParam(":id_receita", $id_receita);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":data_criacao", $data_criacao);
        $stmt->bindParam(":modo_preparo", $modo_preparo);
        $stmt->bindParam(":qtde_porcao", $qtde_porcao);
       
        $stmt->bindParam(":id_Categoria", $id_Categoria);
        $stmt->bindParam(":id_Funcionario", $id_Funcionario);

        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<script> 
                alert('  Receita cadastrado com sucesso!'); 
                window.location.href='index.php';  
                </script>";
                echo "<p> Receita cadastrado com sucesso!</p>";
                $id_receita = null;
                $nome = null;
                $data_criacao = null;
                $modo_preparo = null;
                $qtde_porcao = null;
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

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_Receita != ""){
    try {
        echo "id_Receita :",  $id;
        $stmt = $conexao->prepare("SELECT id_Receita, , nome, data_criacao, modo_preparo, qtde_porcao,id_Categoria,id_Funcionario FROM g4_receita WHERE id_Receita= :id");
       
        $stmt->bindParam(":id", $id_Receita, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id_receita = $rs->$id_receita;
            $nome = $rs->$nome;
            $data_criacao = $rs->$data_criacao;
            $modo_preparo = $rs->$modo_preparo;
            $qtde_porcao = $rs->$qtde_porcao;
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




$sql = " SELECT * FROM g4_funcionario ";

try {
    $stmt = $conexao -> prepare($sql);
    $stmt -> execute();
    $results = $stmt -> fetchAll();
}
catch(Exception $ex){
    echo ($ex -> getMessage());

}
//
$sql = " SELECT * FROM g4_categoria ";

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
    <div class="box-p">
        <div class="box-f1">
            <div class="box-f2">
                <h1>Receita</h1>
                <h2 class="title-01">Incluir</h2>
                <form action="?act=save" method="POST" name="form" class="" >
                    <div class="grid">
                        <div>
                            <span class="">Receita*</span>
                            <input required type="text" name="nome" placeholder="Inserir" value="<?php
                            echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
                            ?>" class="form-control"/>
                        </div>
                        <div>
                            <span class="">Data de criação*</span>
                            <input required type="date" name="data_criacao" placeholder="Inserir" value="<?php
                            echo (isset($data_criacao) && ($data_criacao != null || $data_criacao != "")) ? $data_criacao : '';
                            ?>" class="form-control"/>
                        </div>
                        <div>
                            <span class="">Modo de preparo*</span>
                            <input required type="text" name="modo_preparo" placeholder="Inserir" value="<?php
                            echo (isset($modo_preparo) && ($modo_preparo != null || $modo_preparo != "")) ? $modo_preparo : '';
                            ?>" class="form-control"/>
                        </div>
                        <div>
                            <span class="">Quantidade por porção*</span>
                            <input required type="text" name="qtde_porcao" placeholder="Inserir" value="<?php
                            echo (isset($qtde_porcao) && ($qtde_porcao != null || $qtde_porcao != "")) ? $qtde_porcao : '';
                            ?>" class="form-control"/>
                        </div>
                        <div>
                            <span class="">Categoria*</span>
                            <select required id="id_Categoria" name="id_Categoria">
                                <option value="" disabled selected>Categoria</option>
                                    <?php foreach($results1 as $output) {?>
                                <option value="<?php echo $output["id_Categoria"];?>"><?php echo $output["descricao"];?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div>
                            <span class="">Funcionario*</span>
                            <select required id="id_Funcionario" name="id_Funcionario">
                                <option value="" disabled selected>Funcinario</option>
                                <option value="" disabled selected>Funcionario</option>
                                <option>Funcionario</option>
                                    <?php foreach($results as $output) {?>
                                <option value="<?php echo $output["id_Funcionario"];?>"><?php echo $output["nome"];?></option>
                                <?php } ?>
                            </select>
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
                                    <th>Nome da Receita</th>
                                    <th>Data de criação</th>
                                    <th>Modo de preparo</th>
                                    <th>Qtde por porção</th>
                                    <th>ID Categoria</th>
                                    <th>ID funcionario</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    try {
                                        $stmt = $conexao->prepare("SELECT * FROM g4_receita");
                                        if ($stmt->execute()) {
                                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                echo "<tr>";
                                                echo "<td>$rs->id_Receita</td>";
                                                echo "<td>$rs->nome</td>";
                                                echo "<td>$rs->data_criacao</td>";
                                                echo "<td>$rs->modo_preparo</td>";
                                                echo "<td>$rs->qtde_porcao</td>";
                                                echo "<td>$rs->id_Categoria</td>";
                                                echo "<td>$rs->id_Funcionario</td>";
                                            
                        
                                                //Alterar 
                                                echo '<td><a href="./alterar.php?id='.$rs->id_Receita.'">Alterar</a></td>';
                                                //excluir
                                                echo '<td><a href="./excluir.php?id=' .$rs->id_Receita. '">Excluir</a></td>';
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