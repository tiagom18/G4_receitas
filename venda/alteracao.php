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
  $id_Venda = $_GET["id"];
  $data_venda = $_GET["data_venda"];
  $situacao = $_GET["situacao"];
  $id_func = $_GET["id_func"];
  $id_Horta = $_GET["id_Horta"];
  $id_Cliente = $_GET["id_Cliente"];
  include("../model/conexao.php");

  try{
    $query = "UPDATE mh_venda
    SET data_venda = :data_venda,
     situacao = :situacao,
    id_func = :id_func,
    id_Horta = :id_Horta,
    id_Cliente = :id_Cliente
    WHERE id_Venda = :id;";

    $stmt=$conexao->prepare($query);

    $stmt->bindParam(":data_venda", $data_venda, PDO::PARAM_STR);
    $stmt->bindParam(":situacao", $situacao, PDO::PARAM_INT );
    $stmt->bindParam(":id_func", $id_func, PDO::PARAM_STR);
    $stmt->bindParam(":id_Horta", $id_Horta, PDO::PARAM_STR);
    $stmt->bindParam(":id_Cliente", $id_Cliente, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id_Venda, PDO::PARAM_INT);

    $stmt->execute();

    echo "Alteração efetuada com sucesso";

  } catch (PDOException $erro) {
    echo "ERRO:". $erro->getMessage();
  }


?>  
 <br>
 <a href="index.php">Ver cursos cadastrados</a>
 
 </body>
</html>

