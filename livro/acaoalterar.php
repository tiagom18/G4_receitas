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
        $id_Livro = $_GET["id"];
        $titulo = $_GET["titulo"];
        $isbn = $_GET["isbn"];
        $editor = $_GET["editor"];
        include('../model/conexao.php');
        include ('../includes/header.php');

      try{
        $query = "UPDATE g4_livro
        SET titulo = :titulo,
        isbn =:isbn,
        editor =:editor
        WHERE id_Livro = :id;";

        $stmt=$conexao->prepare($query);

        $stmt->bindParam(":titulo", $titulo, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id_Livro, PDO::PARAM_INT);
        $stmt->bindParam(":isbn", $isbn, PDO::PARAM_STR);
        $stmt->bindParam(":editor", $editor, PDO::PARAM_STR);

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

