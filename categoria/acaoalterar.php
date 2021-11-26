<!DOCTYPE html>
<!-- alteracao.php -->
<html>
	<head>
	  <title>Cadastro de vendas - Alteração</title>
    <link href="./style.css" rel="stylesheet"/>
	  <meta charset="utf-8">
    
      
	</head>
	<body>
        <!-- centralizar tudo e cria um botão bonito de voltar-->
    <?php 
    // efetua alteração do curso informado em form_alteracao.php
        $id_Categoria = $_GET["id"];
        $descricao = $_GET["descricao"];
        include('../model/conexao.php');
        include ('../includes/header.php');

      try{
        $query = "UPDATE g4_categoria
        SET descricao = :descricao
        WHERE id_Categoria = :id;";

        $stmt=$conexao->prepare($query);

        $stmt->bindParam(":descricao", $descricao, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id_Categoria, PDO::PARAM_INT);

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

