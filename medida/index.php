<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Medida</title>
</head>
<?php 
//conexão
include('../model/conexao.php');
//header
include ('../includes/header.php');
//verificando o POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_Medida = filter_input(INPUT_POST,'id_Medida');
    $descricao = filter_input(INPUT_POST,'descricao');
} else if (!isset($id_Medida)){
    $id_Medida = (isset($_GET["id_Medida"]) && $_GET["id_Medida"] != null) ? $_GET["id_Medida"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $descricao != "") {
    try{
        if ($id_Medida != "") {
            $stmt = $conexão->prepare("UPDATE g4_medida SET descricao=? WHERE id_Medida = ?");
            $stmt->bindParam(2, $id_Medida);
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_medida(descricao) VALUES (?)");
        }
        $stmt->bindParam(1, $descricao);
        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<script> 
                alert(' Medida cadastrado com sucesso!'); 
                window.location.href='index.php';  
                </script>";
                echo "<p class='txt_medida'> Medida cadastrado com sucesso!</p>";
                $id_Medida = null;
                $descricao = null;
            } else {
                echo "<p>Erro no cadastro do Medida</p>";
            }
        } else {
            echo "<p>Erro: Não foi possivel executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro:" .$erro->getMessage(). "</p>";
    }

}

//UPD
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_Medida != ""){
    try {
        echo "id_Medida :",  $id;
        $stmt = $conexao->prepare("SELECT * FROM g4_medida WHERE id_Medida= :id");
        $stmt->bindParam(":id", $id_Medida, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id_Medida = $rs->$id_Medida;
            $descricao = $rs->$descricao;
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
                <h1>Medida</h1>
                <h2 class="title-01">Incluir</h2>
                <form action="?act=save" method="POST" name="form" class="" >
                    <label for="descricao">Descrição*</label>
                    <input required type="text" name="descricao"  placeholder="Inserir" value="<?php
                    echo (isset($descricao) && ($descricao != null || $descricao != "")) ? $descricao : '';?>">
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
                                        $stmt = $conexao->prepare("SELECT * FROM g4_medida");
                                        if ($stmt->execute()) {
                                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                echo "<tr>";
                                                echo "<td>$rs->id_Medida</td>";
                                                echo "<td>$rs->descricao</td>";
                                                //Alterar 
                                                echo '<td><a href="./alterar.php?id='.$rs->id_Medida.'">Alterar</a></td>';
                                                //excluir
                                                echo '<td><a href="./excluir.php?id=' .$rs->id_Medida. '">Excluir</a></td>';
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