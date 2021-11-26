<!DOCTYPE html>
<!-- alteracao.php -->
<html>
	<head>
	  <title>Cadastro de vendas - Alteração</title>
    <link href="./style.css" rel="stylesheet"/>
	  <meta charset="utf-8">
      
	</head>
	<body>
    <!-- centralizar tudo e cria um botão bonito de voltar -->
    <?php 
    // efetua alteração do curso informado em form_alteracao.php
        $id_Degustacao = $_GET["id"];
        $nota = $_GET["nota"];
        $data_nota = $_GET["data_nota"];
        $id_Funcionario = $_GET["id_Funcionario"];
        $id_Receita = $_GET["id_Receita"];
        include('../model/conexao.php');
        include ('../includes/header.php');

      try{
        $query = "UPDATE g4_degustacao
        SET nota = :nota,
        data_nota = :data_nota,
        id_Funcionario = :id_Funcionario,
        id_Receita = :id_Receita
        WHERE id_Degustacao = :id;";

        $stmt=$conexao->prepare($query);

        $stmt->bindParam(":nota", $nota, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id_Degustacao, PDO::PARAM_INT);
        $stmt->bindParam(":data_nota", $data_nota, PDO::PARAM_STR);
        $stmt->bindParam(":id_Funcionario", $id_Funcionario, PDO::PARAM_STR);
        $stmt->bindParam(":id_Receita", $id_Receita, PDO::PARAM_STR);


        $stmt->execute();

        echo "<script> 
          alert('Dado alterado com sucesso'); 
          window.location.href='index.php';  
          </script>";

      } catch (PDOException $erro) {
        echo "ERRO:". $erro->getMessage();
      }


    ?>  
 </body>
</html>

