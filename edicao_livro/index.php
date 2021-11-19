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
    $editor = filter_input(INPUT_POST,'editor');
    $isbn = filter_input(INPUT_POST,'isbn');
} else if (!isset($id_Livro)){
    $id_Livro = (isset($_GET["id_Livro"]) && $_GET["id_Livro"] != null) ? $_GET["id_Livro"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $titulo != "") {
    try{
        if ($id_Livro != "") {
            $stmt = $conexão->prepare("UPDATE g4_publicacao SET id_Publicacao=:id_Publicacao, id_Livro=:id_Livro, id_Receita=:id_Receita WHERE id_Publicacao=:id_Publicacao");
            $stmt->bindParam(":id_Publicacao", $id_Publicacao);
            
        } else {
            $stmt = $conexao->prepare("INSERT INTO g4_publicacao(id_Publicacao, id_Livro, id_Receita) VALUES (:id_Publicacao, :id_Livro, :id_Receita)");
        }
        $stmt->bindParam(":id_Livro", $id_Livro);
        $stmt->bindParam(":id_Receita", $id_Receita);
        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<script> 
                alert('  Edição do livro cadastrado com sucesso!'); 
                window.location.href='index.php';  
                </script>";
                echo "<p> Edição do livro cadastrado com sucesso!</p>";
                $id_Livro = null;
                $id_Receita = null;
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
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id_Publicacao != ""){
    try {
        echo "id_Livro :",  $id;
        $stmt = $conexao->prepare("SELECT id_Publicacao, id_Livro, id_Receita FROM g4_Publicacao WHERE id_Publicacao= :id");
        $stmt->bindParam(":id", $id_Publicacao, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id_Publicacao = $rs->$id_Publicacao;
            $id_Livro = $rs->$id_Livro;
            $id_Receita = $rs->$id_Receita;
        } else {
            echo "<p>Não foi possível executar a declaração sql</p>";
        }
    } catch (PDOException $erro) {
        echo "<p>Erro".$erro->getMessage()."</p>";
    }
}
//pegando as informações para o dropbox - Livro
$sql = " SELECT id_Livro, titulo FROM g4_livro";
try {
    $stmt = $conexao -> prepare($sql);
    $stmt -> execute();
    $results = $stmt -> fetchAll();
}
catch(Exception $ex){
    echo ($ex -> getMessage());

}
//pegando as informações para a checklist - Receita
$sql = " SELECT * FROM g4_Receita";
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
    <!--Seleciona o livro a ser trabalhado-->

    <span>Escolha o livro</span>
    <form action="?act=save" method="POST" name="form" class="" >

        <label for="titulo" >Nome do livro</label>
        <select id="titulo" name="titulo">
            <option>Escolha o livro </option>
                <?php foreach($results as $output) {?>
            <option value="<?php $output["id_Livro"]?>"><?php echo $output["titulo"];?></option> <?php } ?>
        </select>
        </br>
        <!--Opções de receita-->
        <input>
        <label></label>
        <button type="submit" class = "">Editar livro</button>
        <button type="reset" class = "">Cancelar</button>
        <hr>
    </form>
    <!-- Apresenta todas as receitas do sistema -->
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nome da Receita</th>
            </tr>
        </thead>
        <tbody>
            <?php
                try {
                    $stmt = $conexao->prepare("SELECT id_Receita, nome FROM g4_receita");
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>$rs->id_Receita</td>";
                            echo "<td>$rs->nome</td>";
                            
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
    
    <h3>Editar</h3>
    <!--Mostra o Livro Selecionado -->
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Editor</th>
                <th>Título</th>
                <th>ISBN</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                try {
                    $stmt = $conexao->prepare("SELECT id_Livro, editor, titulo, isbn FROM g4_livro WHERE id_Livro = :id");
                    $stmt->bindParam(":id", $id_Livro, PDO::PARAM_INT);
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>$rs->id_Livro</td>";
                            echo "<td>$rs->editor</td>";
                            echo "<td>$rs->titulo</td>";
                            echo "<td>$rs->isbn</td>";
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