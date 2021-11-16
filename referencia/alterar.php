<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../includes/style.css"> 
    <title>Referência</title>
</head>
<body>
    <?php
        //header
            include ('../includes/header.php');
        //conexão
            include('../model/conexao.php');
        //recuperando as informações salvas no save do index.php
            $id_Referencia = $_GET["id"];

            try {
                $stmt = $conexao->prepare("SELECT * FROM g4_referencia WHERE id_Referencia = :id");
                $stmt->bindParam(":id", $id_Referencia, PDO::PARAM_INT);
                if ($stmt->execute()) {
                   while ($rs = $stmt->fetch(PDO::FETCH_OBJ)){
                    $id_Referencia = $rs->id_Referencia;
                    $data_inicio = $rs->data_inicio;
                    $data_fim = $rs->data_fim;
                    $id_Restaurante = $rs->id_Restaurante;
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
                $id_Referencia = filter_input(INPUT_POST,'id_Referencia');
                $data_inicio = filter_input(INPUT_POST,'data_inicio');
                $data_fim = filter_input(INPUT_POST,'data_fim');
                $id_Restaurante = filter_input(INPUT_POST,'id_Restaurante');
                $id_Funcionario = filter_input(INPUT_POST,'id_Funcionario');
            } else if (!isset($id_Referencia)){
                $id_Referencia = (isset($_GET["id_Referencia"]) && $_GET["id_Referencia"] != null) ? $_GET["id_Referencia"] : "";
            }
      
         //pegar as opções do banco 
         $sql = " SELECT * FROM g4_restaurante";
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
        <input type="hidden" name="id" value="<?php echo (isset($id_Referencia) && ($id_Referencia != null || $id_Referencia != "")) ? $id_Referencia : ''; ?>"/>
        
        <label for="data_inicio">Data de Inicio*</label>
        <input required type="date" name="data_inicio" value="<?php echo (isset($data_inicio) && ($data_inicio != null || $data_inicio != "")) ? $data_inicio : ''; ?>" />

        <label for="data_fim">Data do Fim*</label>
        <input required type="date" name="data_fim" value="<?php echo (isset($data_fim) && ($data_fim != null || $data_fim != "")) ? $data_fim : ''; ?>" />

        <select required  id="id_Restaurante" name="id_Restaurante">
            <option>Funcionario*</option>
                <?php foreach($results as $output) {?>
                    <option <?php echo $id_Restaurante == $output["id_Restaurante"]?  "selected" : ""; ?> value="<?php echo $output["id_Restaurante"];?>"><?php echo $output["nome"];?></option>
                <?php } ?>
        </select>

        <select required id="id_Funcionario" name="id_Funcionario">
            <option>Funcionario*</option>
                <?php foreach($results1 as $output) {?>
                    <option <?php echo $id_Funcionario == $output["id_Funcionario"]?  "selected" : ""; ?> value="<?php echo $output["id_Funcionario"];?>"><?php echo $output["nome"];?></option>
                <?php } ?>
        </select>
              
        <button type="submit" >Salvar</button>
    </form>
    <hr/>
    <!--apresenta um consultar -->
    <h3>Referências cadastrados</h3>
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
                    $stmt = $conexao->prepare("SELECT * FROM g4_referencia");
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>$rs->id_Referencia</td>";
                            echo "<td>$rs->data_inicio</td>";
                            echo "<td>$rs->data_fim</td>";
                            echo "<td>$rs->id_Restaurante</td>";
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