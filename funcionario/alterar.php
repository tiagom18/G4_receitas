<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/style.css"> 
    <title>Funcinario</title>
</head>
<body>
    <?php
        //header
            include ('../includes/header.php');
        //conexão
            include('../model/conexao.php');
        //recuperando as informações salvas no save do index.php
            $id_Funcionario = $_GET["id"];
            

            try {
                $stmt = $conexao->prepare("SELECT a.id_Funcionario, a.nome, a.rg, a.data_ingresso, a.nome_fantasia, a.Usuario, a.senha, b.id_Cargo FROM g4_funcionario as a INNER JOIN g4_cargo as b on a.id_Cargo = b.id_Cargo WHERE id_Funcionario = :id");
                $stmt->bindParam(":id", $id_Funcionario, PDO::PARAM_INT);
                if ($stmt->execute()) {
                   while ($rs = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id_Funcionario = $rs->id_Funcionario;
                    $nome = $rs->nome;
                    $rg = $rs->rg;
                    $data_ingresso = $rs->data_ingresso;
                    $nome_fantasia = $rs->nome_fantasia;
                    $Usuario = $rs->Usuario;
                    $senha = $rs->senha;
                    $id_Cargo = $rs->id_Cargo;
            
                   }
                } else {
                    echo "<p>Erro: Não foi possível executar a declaração sql</p>";
                }
            } catch (PDOException $erro) {
                echo "<p>Erro: " . $erro->getMessage() . "</p>";
            }

        //verificando o POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id_Funcionario = filter_input(INPUT_POST,'id_Funcionario');
            $nome = filter_input(INPUT_POST,'nome');
            $rg = filter_input(INPUT_POST,'rg');
            $data_ingresso = filter_input(INPUT_POST,'data_ingresso');
            $nome_fantasia = filter_input(INPUT_POST,'nome_fantasia');
            $Usuario = filter_input(INPUT_POST,'Usuario');
            $senha = filter_input(INPUT_POST,'senha');
            $id_Cargo = filter_input(INPUT_POST,'id_Cargo');
        } else if (!isset($id_Funcionario)){
            $id_Funcionario = (isset($_GET["id_Funcionario"]) && $_GET["id_Funcionario"] != null) ? $_GET["id_Funcionario"] : "";
        }
        //    
        //pegar as opções do banco 
        $sql = " SELECT * FROM g4_cargo";
        try {
            $stmt = $conexao -> prepare($sql);
            $stmt -> execute();
            $results = $stmt -> fetchAll();
        }
        catch(Exception $ex){
            echo ($ex -> getMessage());
    
        }
        
    ?>
    <h1>Alterar</h1>
    <!--form-alteração-->
    <form action="acaoalterar.php" method="GET">
        <input type="hidden" name="id" value="<?php echo (isset($id_Funcionario) && ($id_Funcionario != null || $id_Funcionario != "")) ? $id_Funcionario : ''; ?>"/>

        <label for="nome">Funcionario</label>
        <input type="text" name="nome" value="<?php echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : ''; ?>" />

        <label for="rg">RG</label>
        <input type="number" name="rg" value="<?php echo (isset($rg) && ($rg != null || $rg != "")) ? $rg : ''; ?>" />

        <label for="data_ingresso">data_ingresso</label>
        <input type="date" name="data_ingresso" value="<?php echo (isset($data_ingresso) && ($data_ingresso != null || $data_ingresso != "")) ? $data_ingresso : ''; ?>" />

        <label for="nome_fantasia">nome_fantasia</label>
        <input type="text" name="nome_fantasia" value="<?php echo (isset($nome_fantasia) && ($nome_fantasia != null || $nome_fantasia != "")) ? $nome_fantasia : ''; ?>" />

        <label for="Usuario">Usuario</label>
        <input type="text" name="Usuario" value="<?php echo (isset($Usuario) && ($Usuario != null || $Usuario != "")) ? $Usuario : ''; ?>" />

        <label for="senha">senha</label>
        <input type="text" name="senha" value="<?php echo (isset($senha) && ($senha != null || $senha != "")) ? $senha : ''; ?>" />

        <select id="id_Cargo" name="id_Cargo">
        <option>Cargo</option>
        <?php foreach($results as $output) {?>
    <option value="<?php echo $output["id_Cargo"];?>"><?php echo $output["nome"];?></option>
        <?php } ?>
    </select>
        
        <button type="submit" >Salvar</button>
    </form>
    <hr/>
    <!--apresenta um consultar -->
    <h3>Funcinario cadastrados</h3>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>nome</th>
                <th>rg</th>
                <th>data_ingresso</th>
                <th>nome_fantasia</th>
                <th>Usuario</th>
                <th>senha</th>
         
            </tr>
        </thead>
        <tbody>
            <?php
                try {
                    $stmt = $conexao->prepare("SELECT * FROM g4_funcionario");
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>$rs->id_Funcionario</td>";
                            echo "<td>$rs->nome</td>";
                            echo "<td>$rs->rg</td>";
                            echo "<td>$rs->data_ingresso</td>";
                            echo "<td>$rs->nome_fantasia</td>";
                            echo "<td>$rs->Usuario</td>";
                            echo "<td>$rs->senha</td>";
                            
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