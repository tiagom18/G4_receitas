<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="action/style.css">-->
    <title>Edição do livro</title>
</head>
<?php 
//conexão
include('../model/conexao.php');
//header
include ('../includes/header.php');
//verificando o POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_Livro = filter_input(INPUT_POST,'id_Livro');
    $titulo = filter_input(INPUT_POST,'titulo');
} else if (!isset($id_Livro)){
    $id_Livro = (isset($_GET["id_Livro"]) && $_GET["id_Livro"] != null) ? $_GET["id_Livro"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $titulo != "") {
    try{
        if ($id_Livro != "") {
            $stmt = $conexão->prepare("UPDATE g4_livro SET titulo=? WHERE id_Livro = ?");
            $stmt->bindParam(2, $id_Livro);
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_livro(titulo) VALUES (?)");
        }
        $stmt->bindParam(1, $titulo);
        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<p> Edição do livro cadastrado com sucesso!</p>";
                $id_Livro = null;
                $titulo = null;
            } else {
                echo "<p>Erro no cadastro do Edição do livro</p>";
            }
        } else {
            echo "<p>Erro: Não foi possivel executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro:" .$erro->getMessage(). "</p>";
    }

}
//UPD
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_Livro != ""){
    try {
        echo "id_Livro :",  $id;
        $stmt = $conexao->prepare("SELECT * FROM g4_livro WHERE id_Livro= :id");
        $stmt->bindParam(":id", $id_Livro, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id_Livro = $rs->$id_Livro;
            $titulo = $rs->$titulo;
        } else {
            echo "<p>Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro".$erro->getMessage()."</p>";
    }
}
//pegando as informações para o dropbox
$sql = " SELECT * FROM g4_livro";
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

    <span>Escolha o livro</span>
    <form action="?act=save" method="POST" name="form" class="" >

        <label for="titulo" >Nome do livro</label>
        //dropbox
        <select id="titulo" name="titulo">
            <option>Escolha o livro </option>
                <?php foreach($results as $output) {?>
            <option value="<?php $output["id_Livro"]?>"><?php echo $output["titulo"];?></option> <?php } ?>
        </select>

        <button type="submit" class = "">Editar livro</button>
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
                        $stmt = $conexao->prepare("SELECT * FROM g4_livro");
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                echo "<tr>";
                                echo "<td>$rs->id_Livro</td>";
                                echo "<td>$rs->titulo</td>";
                                //Alterar 
                                echo '<td><a href="./alterar.php?id='.$rs->id_Livro.'">Alterar</a></td>';
                                //excluir
                                echo '<td><a href="./excluir.php?id=' .$rs->id_Livro. '">Excluir</a></td>';
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