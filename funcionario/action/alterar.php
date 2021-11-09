<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../includes/style.css"> 
    <title>Funcinario</title>
</head>
<body>
    <?php
        //header
            include ('..\..\includes\header.php');
        //conexão
            include('..\..\model\conexao.php');
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
            } else if (!isset($id_Funcionario)){
                $id_Funcionario = (isset($_GET["id_Funcionario"]) && $_GET["id_Funcionario"] != null) ? $_GET["id_Funcionario"] : "";
            }
        //    
    ?>
    <h1>Alterar</h1>
    <!--form-alteração-->
    <form action="acaoalterar.php" method="GET">
        <input type="hidden" name="id" value="<?php echo (isset($id_Funcionario) && ($id_Funcionario != null || $id_Funcionario != "")) ? $id_Funcionario : ''; ?>"/>

        <label for="nome">Funcionario</label>
        <input type="text" name="nome" value="<?php echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : ''; ?>" />
        <label for="nome">RG</label>
        <input type="text" name="rg" value="<?php echo (isset($rg) && ($rg != null || $rg != "")) ? $rg : ''; ?>" />
        <label for="nome">data_ingresso</label>
        <input type="text" name="data_ingresso" value="<?php echo (isset($data_ingresso) && ($data_ingresso != null || $data_ingresso != "")) ? $data_ingresso : ''; ?>" />
        <label for="nome">nome_fantasia</label>
        <input type="text" name="nome_fantasia" value="<?php echo (isset($nome_fantasia) && ($nome_fantasia != null || $nome_fantasia != "")) ? $nome_fantasia : ''; ?>" />
        <label for="nome">Usuario</label>
        <input type="text" name="Usuario" value="<?php echo (isset($Usuario) && ($Usuario != null || $Usuario != "")) ? $Usuario : ''; ?>" />
        <label for="nome">senha</label>
        <input type="text" name="senha" value="<?php echo (isset($senha) && ($senha != null || $senha != "")) ? $senha : ''; ?>" />

        <button type="submit" >Salvar</button>
    </form>
    <hr/>
    <!--apresenta um consultar -->
    <h3>Funcinario cadastrados</h3>
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
                    $stmt = $conexao->prepare("SELECT * FROM g4_funcionario");
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>$rs->id_Funcionario</td>";
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