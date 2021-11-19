<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet"/>
    <title>Cargo</title>
</head>
<?php 
//conexão
include('../model/conexao.php');
//header
include ('../includes/header.php');
//verificando o POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_Cargo = filter_input(INPUT_POST,'id_Cargo');
    $nome = filter_input(INPUT_POST,'nome');
} else if (!isset($id_Cargo)){
    $id_Cargo = (isset($_GET["id_Cargo"]) && $_GET["id_Cargo"] != null) ? $_GET["id_Cargo"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $nome != "") {
    try{
        if ($id_Cargo != "") {
            $stmt = $conexão->prepare("UPDATE g4_cargo SET nome=? WHERE id_Cargo = ?");
            $stmt->bindParam(2, $id_Cargo);
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_cargo(nome) VALUES (?)");
        }
        $stmt->bindParam(1, $nome);
        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<script> 
                alert('Cargo Cadastrado com sucesso!'); 
                window.location.href='index.php';  
                </script>";
                $id_Cargo = null;
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
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_Cargo != ""){
    try {
        echo "id_Cargo :",  $id;
        $stmt = $conexao->prepare("SELECT * FROM g4_cargo WHERE id_Cargo= :id");
        $stmt->bindParam(":id", $id_Cargo, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id_Cargo = $rs->$id_Cargo;
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
    <div class="box-p">
        <div class="box-f1">
            <div class="box-f2">
                <h1>Cargo</h1>
                <h2 class="title-01">Incluir</h2>
                <form action="?act=save" method="POST" name="form" class="" >
                    <label for="descrição">Descrição*</label>
                    <input required type="text" name="nome" placeholder="Inserir" value="<?php
                    echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';?>">
                    <div class="box-btn">
                        <button type="reset" class = "">Cancelar</button>
                        <button type="submit" class = "">Salvar</button>
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
                                    <th>Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    try {
                                        $stmt = $conexao->prepare("SELECT * FROM g4_cargo");
                                        if ($stmt->execute()) {
                                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                echo "<tr>";
                                                echo "<td>$rs->id_Cargo</td>";
                                                echo "<td>$rs->nome</td>";
                                                //Alterar 
                                                echo '<td><a href="./alterar.php?id='.$rs->id_Cargo.'">Alterar</a></td>';
                                                //excluir
                                                echo '<td><a href="./excluir.php?id=' .$rs->id_Cargo. '">Excluir</a></td>';
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