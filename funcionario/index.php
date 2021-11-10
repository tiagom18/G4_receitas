<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="action/style.css">-->
    <title>Funcionário</title>
</head>
<?php 
//conexão
include('../model/conexao.php');
//header
include ('../includes/header.php');
//verificando o POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_Funcionario = filter_input(INPUT_POST,'id_Funcionario');
    $nome = filter_input(INPUT_POST,'nome');
    $rg = filter_input(INPUT_POST,'rg');
    $data_ingresso = filter_input(INPUT_POST,'data_ingresso');
    $nome_fantasia = filter_input(INPUT_POST,'nome_fantasia');
    $Usuario = filter_input(INPUT_POST,'Usuario');
    $senha = filter_input(INPUT_POST,'senha');
    $id_Cargo = filter_input(INPUT_POST,'id_Cargo');
} else if (!isset($id_Funcionario)){
    $id_Funcionario = (isset($_GET["id_Funcionario"]) && $_GET["id_Funcionario"] != null) ? $_GET["id_Funcionario"] : "";
}

//SAVE - insert
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $nome != "") {
    try{
        if ($id_Funcionario != "") {
            $stmt = $conexão->prepare("UPDATE g4_funcionario SET nome=:nome, rg=:rg, data_ingresso=:data_ingresso, nome_fantasia=:nome_fantasia, Usuario=:Usuario, senha=:senha   WHERE id_Funcionario = :id_Funcionario");
            $stmt->bindParam(":id_Funcionario", $id_Funcionario);
          
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_funcionario(nome, rg, data_ingresso, nome_fantasia, Usuario, senha, id_Cargo) 
            VALUES (:nome,:rg,:data_ingresso,:nome_fantasia,:Usuario,:senha,:id_Cargo)");
        }
     
        $stmt->bindParam(":nome", $nome ,PDO::PARAM_STR);
        $stmt->bindParam(":rg", $rg,PDO::PARAM_STR);
        $stmt->bindParam(":data_ingresso", $data_ingresso ,PDO::PARAM_STR);
        $stmt->bindParam(":nome_fantasia", $nome_fantasia ,PDO::PARAM_STR);
        $stmt->bindParam(":Usuario", $Usuario ,PDO::PARAM_STR);
        $stmt->bindParam(":senha", $senha ,PDO::PARAM_STR);
        $stmt->bindParam(":id_Cargo", $id_Cargo ,PDO::PARAM_STR);
        
        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<p> Cargo cadastrado com sucesso!</p>";
                $id_Funcionario = null;
                $nome = null;
                $rg = null;
                $data_ingresso = null;
                $nome_fantasia = null;
                $Usuario = null;
                $senha = null;
                $id_Cargo = null;
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

        $stmt = $conexao->prepare("SELECT a.id_Funcionario, a.nome, a.rg, a.data_ingresso, a.nome_fantasia, a.Usuario, a.senha, b.id_Cargo FROM g4_funcionario as a INNER JOIN g4_cargo as b on a.id_Cargo = b.id_Cargo WHERE id_Funcionario= :id");

        $stmt = $conexao->prepare("SELECT id_Funcionario, nome, rg, data_ingresso, nome_fantasia, Usuario, senha FROM g4_funcionario WHERE id_funcionario= :id");

        $stmt->bindParam(":id", $id_Funcionario, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id_Funcionario = $rs->$id_Funcionario;
            $nome = $rs->$nome;
            $rg = $rs->$rg;
            $data_ingresso = $rs->$data_ingresso;
            $nome_fantasia = $rs->$nome_fantasia;
            $Usuario = $rs->$Usuario;
            $senha = $rs->$senha;
        } else {
            echo "<p>Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro".$erro->getMessage()."</p>";
    }
}

//pegar as opções do banco 

    $sql = " SELECT * FROM g4_cargo";
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
    <span>Funcionário</span>
    <form action="?act=save" method="POST" name="form" class="" >
        <label for="nome">
			Nome:
		</label>
        </br>
        <input type="text" name="nome" placeholder="Inserir" value="<?php
        echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
        ?>" />
        </br>
        <label for="rg">
			RG:
		</label>
        </br>
        <input type="text" name="rg" placeholder="Inserir" value="<?php
        echo (isset($rg) && ($rg != null || $rg != "")) ? $rg : '';
        ?>" />
        </br>
        <label for="data_ingresso">
        data_ingresso:
		</label>
        </br>
        <input type="date" name="data_ingresso" placeholder="Inserir" value="<?php
        echo (isset($data_ingresso) && ($data_ingresso != null || $data_ingresso != "")) ? $data_ingresso : '';
        ?>" />
        </br>
        <label for="nome_fantasia">
        nome_fantasia:
		</label>
        </br>
        <input type="text" name="nome_fantasia" placeholder="Inserir" value="<?php
        echo (isset($nome_fantasia) && ($nome_fantasia != null || $nome_fantasia != "")) ? $nome_fantasia : '';
        ?>" />
        </br>
        <label for="Usuario">
        Usuario:
		</label>
        </br>
        <input type="text" name="Usuario" placeholder="Inserir" value="<?php
        echo (isset($Usuario) && ($Usuario != null || $Usuario != "")) ? $Usuario : '';
        ?>" />
        </br>
        <label for="senha">
        senha:
		</label>
        </br>
        <input type="text" name="senha" placeholder="Inserir" value="<?php
        echo (isset($senha) && ($senha != null || $senha != "")) ? $senha : '';
        ?>" />
        </br>
        
<select id="id_Cargo" name="id_Cargo">
        <option>Cargo</option>
        <?php foreach($results as $output) {?>
    <option value="<?php echo $output["id_Cargo"];?>"><?php echo $output["nome"];?></option>
        <?php } ?>
    </select>

    
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
                    <th>nome</th>
                    <th>rg</th>
                    <th>data_ingresso</th>
                    <th>nome_fantasia</th>
                    <th>Usuario</th>
                    <th>senha</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    try {
                        $stmt = $conexao->prepare("SELECT a.id_Funcionario, a.nome, a.rg, a.data_ingresso, a.nome_fantasia, a.Usuario, a.senha, b.id_Cargo FROM g4_funcionario as a INNER JOIN g4_cargo as b on a.id_Cargo = b.id_Cargo");
                       
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>$rs->id_Funcionario</td>";
                                echo "<td>$rs->nome</td>";
                                echo "<td>$rs->rg</td>";
                                echo "<td>$rs->data_ingresso</td>";
                                echo "<td>$rs->nome_fantasia</td>";
                                echo "<td>$rs->Usuario</td>";
                                echo "<td>$rs->senha</td>";
                                //Alterar 
                                echo '<td><a href="./alterar.php?id='.$rs->id_Funcionario.'">Alterar</a></td>';
                                //excluir
                                echo '<td><a href="./excluir.php?id=' .$rs->id_Funcionario. '">Excluir</a></td>';
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