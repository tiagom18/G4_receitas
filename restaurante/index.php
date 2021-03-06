<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet"/>
    <title>Restaurante</title>
</head>
<?php 
//conexão
include('../model/conexao.php');
//header
include ('../includes/header.php');
//verificando o POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_Restaurante = filter_input(INPUT_POST,'id_Restaurante');
    $nome = filter_input(INPUT_POST,'nome');
} else if (!isset($id_Restaurante)){
    $id_Restaurante = (isset($_GET["id_Restaurante"]) && $_GET["id_Restaurante"] != null) ? $_GET["id_Restaurante"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $nome != "") {
    try{
        if ($id_Restaurante != "") {
            $stmt = $conexão->prepare("UPDATE g4_restaurante SET nome=? WHERE id_Restaurante = ?");
            $stmt->bindParam(2, $id_Restaurante);
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_restaurante(nome) VALUES (?)");
        }
        $stmt->bindParam(1, $nome);
        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<script> 
                alert(' Restaurante cadastrado com sucesso!'); 
                window.location.href='index.php';  
                </script>";
                echo "<p class='txt_restaurante'> Restaurante cadastrado com sucesso!</p>";
                $id_Restaurante = null;
                $nome = null;
            } else {
                echo "<p>Erro no cadastro do Restaurante</p>";
            }
        } else {
            echo "<p>Erro: Não foi possivel executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro:" .$erro->getMessage(). "</p>";
    }

}

//UPD
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_Restaurante != ""){
    try {
        echo "id_Restaurante :",  $id;
        $stmt = $conexao->prepare("SELECT * FROM g4_restaurante WHERE id_Restaurante= :id");
        $stmt->bindParam(":id", $id_Restaurante, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id_Restaurante = $rs->$id_Restaurante;
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
                <h1>Restaurante</h1>
                <h2 class="title-01">Incluir</h2>
                <form action="?act=save" method="POST" name="form" class="" >
                <label for="restaurante">Restaurante*</label>
                <input required type="text" name="nome" placeholder="Inserir" value="<?php
                echo (isset($nome) && ($nome != null || $nome != "")) ? $nome: '';?>">
                <div class="box-btn">
                    <button type="reset">Cancelar</button>
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </div>

    <!--Fim - Insert form-->
    <!-- Inicio - Read -->
        <div class="box-f3">
                <h2 class="title-02">Consultar</h2>
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
                                        $stmt = $conexao->prepare("SELECT * FROM g4_restaurante");
                                        if ($stmt->execute()) {
                                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                echo "<tr>";
                                                echo "<td>$rs->id_Restaurante</td>";
                                                echo "<td>$rs->nome</td>";
                                                //Alterar 
                                                echo '<td><a href="./alterar.php?id='.$rs->id_Restaurante.'">Alterar</a></td>';
                                                //excluir
                                                echo '<td><a href="./excluir.php?id=' .$rs->id_Restaurante. '">Excluir</a></td>';
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
</body>
</html>