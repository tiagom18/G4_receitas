<!DOCTYPE html>
<!-- cadastro.html -->
<html>
    <head>
      <title>Cadastro de aluno - Exclusão</title>
      <meta charset="utf-8">
    </head>
    <body><?php //exclusao.php
// efetua a exclusão do aluno cujo id seja informado.
  $id = $_GET["id"];

  include_once "../model/conexao.php";

  try{
    $query = "delete from g4_cargo where id_Cargo=:id;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    echo "Exclusão efetuada com sucesso";

  } catch (PDOException $e) {
      echo "ERRO:". $e->getMessage();
  }



 ?>
 <br>
 <a href="index.php">Voltar</a>
 
 </body>
</html>
