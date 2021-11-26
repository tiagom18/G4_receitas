<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet"/> 
    <title>Restaurante</title>
</head>
<body>
    <?php
        //header
            include ('../includes/header.php');
        //conexão
            include('../model/conexao.php');
        //recuperando as informações salvas no save do index.php
            $id_Restaurante = $_GET["id"];

            try {
                $stmt = $conexao->prepare("SELECT * FROM g4_restaurante WHERE id_Restaurante = :id");
                $stmt->bindParam(":id", $id_Restaurante, PDO::PARAM_INT);
                if ($stmt->execute()) {
                   while ($rs = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id_Restaurante = $rs->id_Restaurante;
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
                $id_Restaurante = filter_input(INPUT_POST,'id_Restaurante');
                $nome = filter_input(INPUT_POST,'nome');
            } else if (!isset($id_Restaurante)){
                $id_Restaurante = (isset($_GET["id_Restaurante"]) && $_GET["id_Restaurante"] != null) ? $_GET["id_Restaurante"] : "";
            }
        //    
    ?>
    <!--form-alteração-->
    <div class="box-p">
        <div class="box-f1">
            <div class="box-f2">
                <h1>Restaurante</h1>
                <h2 class="title-01">Alterar</h2>
                <form action="acaoalterar.php" method="GET">
                    <input type="hidden" name="id" value="<?php echo (isset($id_Restaurante) && ($id_Restaurante != null || $id_Restaurante != "")) ? $id_Restaurante : ''; ?>"/>
                    <label for="nome">Restaurante*</label>
                    <input required type="text" name="nome" value="<?php echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : ''; ?>" />
                    <div class="box-btn">
                    <button type="reset" >Cancelar</button>
                    <button type="submit" >Salvar</button>
                </div>
            </form>
        </div>
                <!--apresenta um consultar -->
            <div class="box-f3">
                <h2 class="title-02">Restaurantes cadastrados</h2>
                <div class="box-f4">
                <div class="scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome do Restaurante</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            try {
                                $stmt = $conexao->prepare("SELECT * FROM g4_restaurante");
                                if ($stmt->execute()) {
                                    while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                        echo "<tr>";
                                        echo "<td>$rs->id_Restaurante</td>";
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
            </div>
        </div>
        <br>
        <h2><a href="./index.php">Voltar</a></h2>
        
</body>
</html>