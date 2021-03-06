<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/style.css"> 
    <title>Edição do livro</title>
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
            } else if (!isset($id_Livro)){
                $id_Livro = (isset($_GET["id_Livro"]) && $_GET["id_Livro"] != null) ? $_GET["id_Livro"] : "";
            }
        //    
    ?>
    <h1>Alterar</h1>
    <!--form-alteração-->
    <form action="acaoalterar.php" method="GET">
        <input type="hidden" name="id" value="<?php echo (isset($id_Livro) && ($id_Livro != null || $id_Livro != "")) ? $id_Livro : ''; ?>"/>

        <label for="titulo">Edição do livro</label>
        <input type="text" name="titulo" value="<?php echo (isset($titulo) && ($titulo != null || $titulo != "")) ? $titulo : ''; ?>" />

        <button type="submit" >Salvar</button>
    </form>
    <hr/>
    <!--apresenta um consultar -->
    <h3>Edição do livros cadastrados</h3>
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
    <br>
        <h2><a href="./index.php">Voltar</a></h2>
</body>
</html>