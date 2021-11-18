<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/style.css"> 
    <title>Medida</title>
</head>
<body>
    <?php
        //header
            include ('../includes/header.php');
        //conexão
            include('../model/conexao.php');
        //recuperando as informações salvas no save do index.php
            $id_Medida = $_GET["id"];

            try {
                $stmt = $conexao->prepare("SELECT * FROM g4_medida WHERE id_Medida = :id");
                $stmt->bindParam(":id", $id_Medida, PDO::PARAM_INT);
                if ($stmt->execute()) {
                   while ($rs = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id_Medida = $rs->id_Medida;
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
                $id_Medida = filter_input(INPUT_POST,'id_Medida');
                $descricao = filter_input(INPUT_POST,'descricao');
            } else if (!isset($id_Medida)){
                $id_Medida = (isset($_GET["id_Medida"]) && $_GET["id_Medida"] != null) ? $_GET["id_Medida"] : "";
            }
        //    
    ?>
    <h1>Alterar</h1>
    <!--form-alteração-->
    <form action="acaoalterar.php" method="GET">
        <input type="hidden" name="id" value="<?php echo (isset($id_Medida) && ($id_Medida != null || $id_Medida != "")) ? $id_Medida : ''; ?>"/>

        <label for="descricao">Medida*</label>
        <input required type="text" name="descricao" value="<?php echo (isset($descricao) && ($descricao != null || $descricao != "")) ? $descricao : ''; ?>" />

        <button type="submit" >Salvar</button>
    </form>
    <hr/>
    <!--apresenta um consultar -->
    <h3>Medidas cadastrados</h3>
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
                    $stmt = $conexao->prepare("SELECT * FROM g4_medida");
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>$rs->id_Medida</td>";
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