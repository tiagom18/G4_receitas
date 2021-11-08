<!DOCTYPE html>
<!-- alteracao.php -->
<html>
	<head>
	  <title>Cadastro de vendas - Alteração</title>
	  <meta charset="utf-8">
      
	</head>
	<body>
<?php 
// efetua alteração do curso informado em form_alteracao.php
    $id_Cargo = $_GET["id"];
    $nome = $_GET["nome"];
    include('..\..\model\conexao.php');

  try{
    $query = "UPDATE g4_cargo
    SET nome = :nome
    WHERE id_Cargo = :id;";

    $stmt=$conexao->prepare($query);

    $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id_Cargo, PDO::PARAM_INT);

    $stmt->execute();

    echo "Alteração efetuada com sucesso";

  } catch (PDOException $erro) {
    echo "ERRO:". $erro->getMessage();
  }


?>  
 <br>
 <a href="../index.php">Ver Vendas cadastradas</a>
 
 </body>
</html>

