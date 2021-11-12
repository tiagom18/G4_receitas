<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="action/style.css">-->
    <title>Livro</title>
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
    $isbn = filter_input(INPUT_POST,'isbn');
    $editor = filter_input(INPUT_POST,'editor');
} else if (!isset($id_Livro)){
    $id_Livro = (isset($_GET["id_Livro"]) && $_GET["id_Livro"] != null) ? $_GET["id_Livro"] : "";
}

//SAVE
if (isset($_REQUEST['act']) && $_REQUEST['act'] == "save" && $titulo != "") {
    try{
        if ($id_Livro != "") {
            $stmt = $conexão->prepare("UPDATE g4_livro SET titulo=:titulo, isbn=:isbn, editor=:editor WHERE id_Livro = :id_Livro");
            $stmt->bindParam(":id_Livro", $id_Livro);
            
        } else {
            //cria os valors abaixo
            $stmt = $conexao->prepare("INSERT INTO g4_livro(titulo, isbn, editor) VALUES (:titulo, :isbn, :editor)");
        }
    
        $stmt->bindParam(":titulo", $titulo ,PDO::PARAM_STR);
        $stmt->bindParam(":isbn", $isbn ,PDO::PARAM_STR);
        $stmt->bindParam(":editor", $editor ,PDO::PARAM_STR);
        

        if($stmt->execute())  {
            if ($stmt->rowCount() > 0) {
                echo "<p> Livro cadastrado com sucesso!</p>";
                $id_Livro = null;
                $titulo = null;
                $isbn = null;
                $editor = null;
            } else {
                echo "<p>Erro no cadastro do Livro</p>";
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
            $isbn = $rs->$isbn;
            $editor = $rs->$editor;
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

    <form action="?act=save" method="POST" name="form" class="" >
        <span class="">Livro:</span>
        </br>
        <span class="">Nome do Livro</span>
        </br>
        <input type="text" name="titulo" placeholder="Inserir" value="<?php
        echo (isset($titulo) && ($titulo != null || $titulo != "")) ? $titulo : '';
        ?>" class="form-control"/>
        </br>
        <span class="">ISBN</span>
        </br>
        <input type="text" name="isbn" placeholder="Inserir" value="<?php
        echo (isset($isbn) && ($isbn != null || $isbn != "")) ? $isbn : '';
        ?>" class="form-control"/>
        </br>
        <span class="">Nome do editor</span>
        </br>
        <input type="text" name="editor" placeholder="Inserir" value="<?php
        echo (isset($editor) && ($editor != null || $editor != "")) ? $editor : '';
        ?>" class="form-control"/>
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
                    <th>Titulo</th>
                    <th>ISBN</th>
                    <th>editor</th>
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
                                echo "<td>$rs->isbn</td>";
                                echo "<td>$rs->editor</td>";
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