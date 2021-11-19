<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/style.css"> 
    <title>Categoria</title>
</head>
<body>
    <?php
        //header
            include ('../includes/header.php');
        //conexão
            include('../model/conexao.php');
        //recuperando as informações salvas no save do index.php
            $id_Categoria = $_GET["id"];

            try {
                $stmt = $conexao->prepare("SELECT * FROM g4_categoria WHERE id_Categoria = :id");
                $stmt->bindParam(":id", $id_Categoria, PDO::PARAM_INT);
                if ($stmt->execute()) {
                   while ($rs = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id_Categoria = $rs->id_Categoria;
                    $descricao = $rs->descricao;
                   }
                } else {
                    echo "<p>Erro: Não foi possível executar a declaração sql</p>";
                }
            } catch (PDOException $erro) {
                echo "<p>Erro: " . $erro->getMessage() . "</p>";
            }

        //verificando o POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id_Categoria = filter_input(INPUT_POST,'id_Categoria');
                $descricao = filter_input(INPUT_POST,'descricao');
            } else if (!isset($id_Categoria)){
                $id_Categoria = (isset($_GET["id_Categoria"]) && $_GET["id_Categoria"] != null) ? $_GET["id_Categoria"] : "";
            }
        //    
    ?>
    <h1>Alterar</h1>
    <!--form-alteração-->
    <form action="acaoalterar.php" method="GET">
   
        <input type="hidden" name="id" value="<?php echo (isset($id_Categoria) && ($id_Categoria != null || $id_Categoria != "")) ? $id_Categoria : ''; ?>"/>

        <label for="descricao">Descrição*</label>
        <br>
        <input required type="text" name="descricao" value="<?php echo (isset($descricao) && ($descricao != null || $descricao != "")) ? $descricao : ''; ?>" />

        <button type="submit" >Salvar</button>
    </form>
    <hr/>
    <!--apresenta um consultar -->
    <h3>Categorias cadastrados</h3>
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
                    $stmt = $conexao->prepare("SELECT * FROM g4_categoria");
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>$rs->id_Categoria</td>";
                            echo "<td>$rs->descricao</td>";
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