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
        $id_receita = $_GET["id"];
        $nome = $_GET["nome"];
        $data_criacao = $_GET["data_criacao"];
        $modo_preparo = $_GET["modo_preparo"];
        $qtde_porcao = $_GET["qtde_porcao"];
        $id_Categoria = $_GET["id_Categoria"];
        $id_Funcionario = $_GET["id_Funcionario"];
        include('../model/conexao.php');
        include ('../includes/header.php');

      try{
        $query = "UPDATE g4_receita
        SET nome = :nome,
        data_criacao = :data_criacao,
        modo_preparo = :modo_preparo,
        qtde_porcao = :qtde_porcao,
        id_Categoria = :id_Categoria,
        id_Funcionario = :id_Funcionario
        WHERE id_receita = :id;";

        $stmt=$conexao->prepare($query);

        $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id_receita, PDO::PARAM_INT);
        $stmt->bindParam(":data_criacao", $data_criacao, PDO::PARAM_STR);
        $stmt->bindParam(":modo_preparo", $modo_preparo, PDO::PARAM_STR);
        $stmt->bindParam(":qtde_porcao", $qtde_porcao, PDO::PARAM_STR);
        $stmt->bindParam(":id_Categoria", $id_Categoria, PDO::PARAM_STR);
        $stmt->bindParam(":id_Funcionario", $id_Funcionario, PDO::PARAM_STR);

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

