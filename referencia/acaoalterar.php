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
        $id_Referencia = $_GET["id"];
        $data_inicio = $_GET["data_inicio"];
        $data_fim = $_GET["data_fim"];
        $id_Restaurante = $_GET["id_Restaurante"];
        $id_Funcionario = $_GET["id_Funcionario"];
        
        
        include('../model/conexao.php');
        include ('../includes/header.php');

      try{
        $query = "UPDATE g4_referencia
        SET data_inicio = :data_inicio,
        data_fim = :data_fim,
        id_Restaurante = :id_Restaurante,
        id_Funcionario = :id_Funcionario
        WHERE id_Referencia = :id;";

        $stmt=$conexao->prepare($query);

        $stmt->bindParam(":data_inicio", $data_inicio, PDO::PARAM_STR);
        $stmt->bindParam(":data_fim", $data_fim, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id_Referencia, PDO::PARAM_INT);
        $stmt->bindParam(":id_Restaurante", $id_Restaurante, PDO::PARAM_INT);
        $stmt->bindParam(":id_Funcionario", $id_Funcionario, PDO::PARAM_INT);

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

