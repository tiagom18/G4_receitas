<!DOCTYPE html>
<!-- form_alteracao.html -->
<?php
  include("../model/conexao.php");
  include ("../model/funcoes.inc.php");
  $id_Venda = $_GET["id"];
  $linha = le_venda($conexao, $id_Venda);
?>

<html>
	<head>
	  <title>Cadastro de venda</title>
	  <meta charset="utf-8">
	</head>
	<body>
		<h1>Atualizar venda</h1>
		<form action="alteracao.php" 
		      method="GET">
			  
			<input type="hidden" name="id" value="<?php echo $linha["id_Venda"];?>">
			<label for="data_venda">
			data_venda:
			</label>
			<input type="date" name="data_venda" id="data_venda" value="<?php echo $linha["data_venda"];?>">
			<br>
			<label for="situacao">
			situacao:
			</label>
			<input type="text" name="situacao" id="situacao" value="<?php echo $linha["situacao"];?>">
			<br>
			<label for="id_func">
			id_func:
			</label>
			<input type="txt" name="id_func" id="id_func" value="<?php echo $linha["id_func"];?>">
			<br>
			<label for="id_Horta">
			id_Horta:
			</label>
			<input type="txt" name="id_Horta" id="id_Horta" value="<?php echo $linha["id_Horta"];?>">
			<br>
			id_Cliente:
			</label>
			<input type="txt" name="id_Cliente" id="id_Cliente" value="<?php echo $linha["id_Cliente"];?>">
			<br>
			<input type="submit" value="Ok">
		</form>
	</body>
</html>


