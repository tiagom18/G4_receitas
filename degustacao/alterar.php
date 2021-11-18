<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/style.css"> 
    <title>Degustação</title>
</head>
<body>
    <?php
        //header
            include ('../includes/header.php');
        //conexão
            include('../model/conexao.php');
        //recuperando as informações salvas no save do index.php
            $id_Degustacao = $_GET["id"];

            try {
                $stmt = $conexao->prepare("SELECT * FROM g4_degustacao WHERE id_Degustacao = :id");
                $stmt->bindParam(":id", $id_Degustacao, PDO::PARAM_INT);
                if ($stmt->execute()) {
                   while ($rs = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id_Degustacao = $rs->id_Degustacao;
                    $nota = $rs->nota;
                    $data_nota = $rs->data_nota;
                    $id_Funcionario = $rs->id_Funcionario;
                    $id_Receita = $rs->id_Receita;
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
                $nota = filter_input(INPUT_POST,'nota');
                $data_nota = filter_input(INPUT_POST,'data_nota');
                $id_Funcionario = filter_input(INPUT_POST,'id_Funcionario');
                $id_Receita = filter_input(INPUT_POST,'id_Receita');
            } else if (!isset($id_Degustacao)){
                $id_Degustacao = (isset($_GET["id_Degustacao"]) && $_GET["id_Degustacao"] != null) ? $_GET["id_Degustacao"] : "";
            }
       
        //pegar as opções do banco 
        $sql = " SELECT * FROM g4_funcionario";
        try {
            $stmt = $conexao -> prepare($sql);
            $stmt -> execute();
            $results = $stmt -> fetchAll();
        }
        catch(Exception $ex){
            echo ($ex -> getMessage());
    
        }
   
        $sql = " SELECT * FROM g4_receita";
        try {
            $stmt = $conexao -> prepare($sql);
            $stmt -> execute();
            $results1 = $stmt -> fetchAll();
        }
        catch(Exception $ex){
            echo ($ex -> getMessage());
    
        }
    ?>
    <h1>Alterar</h1>
    <!--form-alteração-->
    <form action="acaoalterar.php" method="GET">
        <input required type="hidden" name="id" value="<?php echo (isset($id_Degustacao) && ($id_Degustacao != null || $id_Degustacao != "")) ? $id_Degustacao : ''; ?>"/>

        <label for="nota">nota da degustação</label>
        <input required type="text" name="nota" value="<?php echo (isset($nota) && ($nota != null || $nota != "")) ? $nota : ''; ?>" />

        <label for="data_nota">data da nota da degustação</label>
        <input required type="date" name="data_nota" value="<?php echo (isset($data_nota) && ($data_nota != null || $data_nota != "")) ? $data_nota : ''; ?>" />

        <select required id="id_Funcionario" name="id_Funcionario">
            <option>Funcionario</option>
                <?php foreach($results as $output) {?>
                    <option <?php echo $id_Funcionario == $output["id_Funcionario"]?  "selected" : ""; ?> value="<?php echo $output["id_Funcionario"];?>"><?php echo $output["nome"];?></option>
                <?php } ?>
        </select>

        <select required id="id_Receita" name="id_Receita">
            <option>Funcionario</option>
                <?php foreach($results1 as $output) {?>
                    <option <?php echo $id_Receita == $output["id_Receita"]?  "selected" : ""; ?> value="<?php echo $output["id_Receita"];?>"><?php echo $output["nome"];?></option>
                <?php } ?>
        </select>

        <button type="submit" >Salvar</button>
    </form>
    <hr/>
    <!--apresenta um consultar -->
    <h3>Degustaçãos cadastrados</h3>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>nota</th>
                <th>data_nota</th>
                <th>id_Funcionario</th>
                <th>id_Receita</th>
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
                            echo "<td>$rs->nota</td>";
                            echo "<td>$rs->data_nota</td>";
                            echo "<td>$rs->id_Funcionario</td>";
                            echo "<td>$rs->id_Receita</td>";
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