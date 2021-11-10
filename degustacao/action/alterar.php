<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../includes/style.css"> 
    <title>Degustação</title>
</head>
<body>
    <?php
        //header
            include ('..\..\includes\header.php');
        //conexão
            include('..\..\model\conexao.php');
        //recuperando as informações salvas no save do index.php
            $id_Degustacao = $_GET["id"];

            try {
                $stmt = $conexao->prepare("SELECT * FROM g4_degustacao WHERE id_Degustacao = :id");
                $stmt->bindParam(":id", $id_Degustacao, PDO::PARAM_INT);
                if ($stmt->execute()) {
                   while ($rs = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id_Degustacao = $rs->id_Degustacao;
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
                $id_Degustacao = filter_input(INPUT_POST,'id_Degustacao');
                $nome = filter_input(INPUT_POST,'nome');
            } else if (!isset($id_Degustacao)){
                $id_Degustacao = (isset($_GET["id_Degustacao"]) && $_GET["id_Degustacao"] != null) ? $_GET["id_Degustacao"] : "";
            }
        //    
    ?>
    <h1>Alterar</h1>
    <!--form-alteração-->
    <form action="acaoalterar.php" method="GET">
        <input type="hidden" name="id" value="<?php echo (isset($id_Degustacao) && ($id_Degustacao != null || $id_Degustacao != "")) ? $id_Degustacao : ''; ?>"/>

        <label for="nome">Degustação</label>
        <input type="text" name="nome" value="<?php echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : ''; ?>" />

        <button type="submit" >Salvar</button>
    </form>
    <hr/>
    <!--apresenta um consultar -->
    <h3>Degustaçãos cadastrados</h3>
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
                    $stmt = $conexao->prepare("SELECT * FROM g4_degustacao");
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>$rs->id_Degustacao</td>";
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

</body>
</html>