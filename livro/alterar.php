<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet"/> 
    <title>Livro</title>
</head>
<body>
    <?php
        //header
            include ('../includes/header.php');
        //conexão
            include('../model/conexao.php');
        //recuperando as informações salvas no save do index.php
            $id_Livro = $_GET["id"];

            try {
                $stmt = $conexao->prepare("SELECT * FROM g4_livro WHERE id_Livro = :id");
                $stmt->bindParam(":id", $id_Livro, PDO::PARAM_INT);
                if ($stmt->execute()) {
                   while ($rs = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id_Livro = $rs->id_Livro;
                    $titulo = $rs->titulo;
                    $isbn = $rs->isbn;
                    $editor = $rs->editor;
                   }
                } else {
                    echo "<p>Erro: Não foi possível executar a declaração sql</p>";
                }
            } catch (PDOException $erro) {
                echo "<p>Erro: " . $erro->getMessage() . "</p>";
            }

        //verificando o POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id_Livro = filter_input(INPUT_POST,'id_Livro');
                $titulo = filter_input(INPUT_POST,'titulo');
                $isbn = filter_input(INPUT_POST,'isbn');
                $editor = filter_input(INPUT_POST,'editor');
            } else if (!isset($id_Livro)){
                $id_Livro = (isset($_GET["id_Livro"]) && $_GET["id_Livro"] != null) ? $_GET["id_Livro"] : "";
            }
        //    
    ?>
    <!--form-alteração-->
    <div class="box-p">
        <div class="box-f1">
            <div class="box-f2">
                <h1>Livro</h1>
                <h2 class="title-01">Alterar</h2>
                <form action="acaoalterar.php" method="GET">
                    <input type="hidden" name="id" value="<?php echo (isset($id_Livro) && ($id_Livro != null || $id_Livro != "")) ? $id_Livro : ''; ?>"/>
                    <label for="titulo">Nome do Livro*</label>
                    <input type="text" name="titulo" value="<?php echo (isset($titulo) && ($titulo != null || $titulo != "")) ? $titulo : ''; ?>" />
                    <label for="isbn">ISBN*</label>
                    <input type="text" name="isbn" value="<?php echo (isset($isbn) && ($isbn != null || $isbn != "")) ? $isbn : ''; ?>" />
                    <label for="editor">Editor*</label>
                    <input type="text" name="editor" value="<?php echo (isset($editor) && ($editor != null || $editor != "")) ? $editor : ''; ?>" />
                    <div class="box-btn">
                    <button type="reset" >Cancelar</button>
                    <button type="submit" >Salvar</button>
                </div>
            </form>
        </div>
                <!--apresenta um consultar -->
            <div class="box-f3">
                <h2 class="title-02">Livros cadastrados</h2>
                <div class="box-f4">
                <div class="scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome do livro</th>
                            <th>ISBN</th>
                            <th>Nome do editor</th>
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
        <br>
        <h2><a href="./index.php">Voltar</a></h2>
</body>
</html>