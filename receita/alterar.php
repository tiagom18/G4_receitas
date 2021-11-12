<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/style.css"> 
    <title>Receita</title>
</head>
<body>
    <?php
        //header
            include ('../includes/header.php');
        //conexão
            include('../model/conexao.php');
        //recuperando as informações salvas no save do index.php
            $id_Receita = $_GET["id"];

            try {
                $stmt = $conexao->prepare("SELECT * FROM g4_receita WHERE id_Receita = :id");
                $stmt->bindParam(":id", $id_Receita, PDO::PARAM_INT);
                if ($stmt->execute()) {
                   while ($rs = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id_Receita = $rs->id_Receita;
                    $nome = $rs->nome;
                    $data_criacao = $rs->data_criacao;
                    $modo_preparo = $rs->modo_preparo;
                    $qtde_porcao = $rs->qtde_porcao;
                    $id_Categoria = $rs->id_Categoria;
                    $id_Funcionario = $rs->id_Funcionario;
                   }
                } else {
                    echo "<p>Erro: Não foi possível executar a declaração sql</p>";
                }
            } catch (PDOException $erro) {
                echo "<p>Erro: " . $erro->getMessage() . "</p>";
            }

        //verificando o POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id_Receita = filter_input(INPUT_POST,'id_Receita');
                $nome = filter_input(INPUT_POST,'nome');
                $data_criacao = filter_input(INPUT_POST,'data_criacao');
                $modo_preparo = filter_input(INPUT_POST,'modo_preparo');
                $qtde_porcao = filter_input(INPUT_POST,'qtde_porcao');
                $id_Categoria = filter_input(INPUT_POST,'id_Categoria');
                $id_Funcionario = filter_input(INPUT_POST,'id_Funcionario');
            } else if (!isset($id_Receita)){
                $id_Receita = (isset($_GET["id_Receita"]) && $_GET["id_Receita"] != null) ? $_GET["id_Receita"] : "";
            }
         
        //pegar as opções do banco 
        $sql = " SELECT * FROM g4_categoria";
        try {
            $stmt = $conexao -> prepare($sql);
            $stmt -> execute();
            $results = $stmt -> fetchAll();
        }
        catch(Exception $ex){
            echo ($ex -> getMessage());
    
        }
        $sql = " SELECT * FROM g4_funcionario";
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
        <input type="hidden" name="id" value="<?php echo (isset($id_Receita) && ($id_Receita != null || $id_Receita != "")) ? $id_Receita : ''; ?>"/>

        <label for="nome">Receita</label>
        <input type="text" name="nome" value="<?php echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : ''; ?>" />

        <label for="data_criacao">data de criação</label>
        <input type="date" name="data_criacao" value="<?php echo (isset($data_criacao) && ($data_criacao != null || $data_criacao != "")) ? $data_criacao : ''; ?>" />

        <label for="modo_preparo">modo de preparo</label>
        <input type="text" name="modo_preparo" value="<?php echo (isset($modo_preparo) && ($modo_preparo != null || $modo_preparo != "")) ? $modo_preparo : ''; ?>" />

        <label for="qtde_porcao">quantidade por porção</label>
        <input type="text" name="qtde_porcao" value="<?php echo (isset($qtde_porcao) && ($qtde_porcao != null || $qtde_porcao != "")) ? $qtde_porcao : ''; ?>" />

        <select id="id_Categoria" name="id_Categoria">
            <option>categoria</option>
                <?php foreach($results as $output) {?>
                    <option <?php echo $id_Categoria == $output["id_Categoria"]?  "selected" : ""; ?> value="<?php echo $output["id_Categoria"];?>"><?php echo $output["descricao"];?></option>
                <?php } ?>
        </select>
        <select id="id_Funcionario" name="id_Funcionario">
            <option>Funcionario</option>
                <?php foreach($results1 as $output) {?>
                    <option <?php echo $id_Funcionario == $output["id_Funcionario"]?  "selected" : ""; ?> value="<?php echo $output["id_Funcionario"];?>"><?php echo $output["nome"];?></option>
                <?php } ?>
        </select>

        <button type="submit" >Salvar</button>
    </form>
    <hr/>
    <!--apresenta um consultar -->
    <h3>Receitas cadastrados</h3>
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
                    $stmt = $conexao->prepare("SELECT * FROM g4_receita");
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>$rs->id_Receita</td>";
                            echo "<td>$rs->nome</td>";
                            echo "<td>$rs->data_criacao</td>";
                            echo "<td>$rs->modo_preparo</td>";
                            echo "<td>$rs->qtde_porcao</td>";
                            echo "<td>$rs->id_Categoria</td>";
                            echo "<td>$rs->id_Funcionario</td>";
                          
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