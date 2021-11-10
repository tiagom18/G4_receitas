<!DOCTYPE html>
<!-- alteracao.php -->
<html>
	<head>
	  <title>Cadastro de vendas - Alteração</title>
    <link rel="stylesheet" href="../includes/style.css"> 
	  <meta charset="utf-8">
      
	</head>
	<body>
    <!-- centralizar tudo e cria um botão bonito de voltar -->
<?php 
// efetua alteração do curso informado em form_alteracao.php
    $id_Funcionario = $_GET["id"];
    $nome = $_GET["nome"];
    $data_ingresso = $_GET["data_ingresso"];
    $nome_fantasia = $_GET["nome_fantasia"];
    $Usuario = $_GET["Usuario"];
    $senha = $_GET["senha"];
   
  

    include('../model/conexao.php');
    include ('../includes/header.php');

  try{
    $query = "UPDATE g4_funcionario
    SET nome = :nome,
    data_ingresso = :data_ingresso,
    nome_fantasia = :nome_fantasia,
    Usuario = :Usuario,
    senha = :senha
 

    WHERE id_Funcionario = :id;";


    $stmt=$conexao->prepare($query);

    $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id_Funcionario, PDO::PARAM_INT);
    $stmt->bindParam(":data_ingresso", $data_ingresso, PDO::PARAM_INT);
    $stmt->bindParam(":nome_fantasia", $nome_fantasia, PDO::PARAM_INT);
    $stmt->bindParam(":Usuario", $Usuario, PDO::PARAM_INT);
    $stmt->bindParam(":senha", $senha, PDO::PARAM_INT);
   

  

    $stmt->execute();

    echo "Alteração efetuada com sucesso";

  } catch (PDOException $erro) {
    echo "ERRO:". $erro->getMessage();
  }


?>  
 <br>
 <a href="./index.php">Voltar</a>
 
 </body>
</html>

