<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/style.css"> 
    <title>Ingrediente</title>
</head>
<body>
    <?php
        //header
            include ('../includes/header.php');
        //conexão
            include('../model/conexao.php');
        //recuperando as informações salvas no save do index.php
            $id_Ingrediente = $_GET["id"];

            try {
                $stmt = $conexao->prepare("SELECT * FROM g4_ingrediente  WHERE id_Ingrediente = :id");
                $stmt->bindParam(":id", $id_Ingrediente, PDO::PARAM_INT);
                if ($stmt->execute()) {
                   while ($rs = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id_Ingrediente = $rs->id_Ingrediente;
                    $descricao = $rs->descricao;
                    $nome = $rs->nome;

                   }
                } else {
                    echo "<p>Erro: Não foi possível executar a declaração sql</p>";
                }
            } catch (PDOException $erro) {
                echo "<p>Erro: " . $erro->getMessage() . "</p>";
            }

        //verificando o POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id_Ingrediente = filter_input(INPUT_POST,'id_Ingrediente');
                $descricao = filter_input(INPUT_POST,'descricao');
                $nome = filter_input(INPUT_POST,'nome');
            } else if (!isset($id_Ingrediente)){
                $id_Ingrediente = (isset($_GET["id_Ingrediente"]) && $_GET["id_Ingrediente"] != null) ? $_GET["id_Ingrediente"] : "";
            }
        //    
    ?>
    <h1>Alterar</h1>
    <!--form-alteração-->
    <form action="acaoalterar.php" method="GET">
        <input type="hidden" name="id" value="<?php echo (isset($id_Ingrediente) && ($id_Ingrediente != null || $id_Ingrediente != "")) ? $id_Ingrediente : ''; ?>"/>

        <label for="nome">Nome*</label>
        <input required type="text" name="nome" value="<?php echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : ''; ?>" />

        <label for="descricao">Descricao*</label>
        <input required type="text" name="descricao" value="<?php echo (isset($descricao) && ($descricao != null || $descricao != "")) ? $descricao : ''; ?>" />

        <button type="submit" >Salvar</button>
    </form>
    <hr/>
    <!--apresenta um consultar -->
    <h3>Ingredientes cadastrados</h3>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Descrição</th>
                <th>nome</th>
            </tr>
        </thead>
        <tbody>
            <?php
                try {
                    $stmt = $conexao->prepare("SELECT * FROM g4_ingrediente ");
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>$rs->id_Ingrediente</td>";
                            echo "<td>$rs->descricao</td>";
                            echo "<td>$rs->nome</td>";
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
    <a href="./index.php">Voltar</a>
</body>
</html>