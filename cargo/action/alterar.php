<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../includes/style.css"> 
    <title>Cargo</title>
</head>
<body>
    <?php
        //header
            include ('..\..\includes\header.php');
        //conexão
            include('..\..\model\conexao.php');
        //recuperando as informações salvas no save do index.php
            $id_Cargo = $_GET["id_Cargo"];

            try {
                $stmt = $conexao->prepare("SELECT * FROM g4_Cargo WHERE id_Cargo = :id");
                $stmt->bindParam(":id", $id_Cargo, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $rs = $stmt->fetch(PDO::FETCH_OBJ);
                    $id_Cargo = $rs->id_Cargo;
                    $nome = $rs->nome;
                } else {
                    echo "<p>Erro: Não foi possível executar a declaração sql</p>";
                }
            } catch (PDOException $erro) {
                echo "<p>Erro: " . $erro->getMessage() . "</p>";
            }

        //verificando o POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id_Cargo = filter_input(INPUT_POST,'id_Cargo');
                $nome = filter_input(INPUT_POST,'nome');
            } else if (!isset($id_Cargo)){
                $id_Cargo = (isset($_GET["id_Cargo"]) && $_GET["id_Cargo"] != null) ? $_GET["id_Cargo"] : "";
            }
        //    
    ?>
    <h1>Alterar</h1>
    <!--form-alteração-->
    <form action="?act=upd" method="POST">
        <input type="hidden" name="id_Cargo" value="<?php echo (isset($id_Cargo) && ($id_Cargo != null || $id_Cargo != "")) ? $id_Cargo : ''; ?>"/>

        <label for="nome">Cargo</label>
        <input type="text" name="nome" value="<?php echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : ''; ?>" />

        <button type="submit" >Salvar</button>
    </form>
    <hr/>
    <!--apresenta um consultar -->
    <h3>Cargos cadastrados</h3>
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
                    $stmt = $conexao->prepare("SELECT * FROM g4_cargo");
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>$rs->id_Cargo</td>";
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