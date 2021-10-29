<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../includes/style.css"> 
    <title>Cargo</title>
</head>
<body>
    <?php
        //header
            include ('..\..\includes\header.php');
        //conexão
            include('..\..\model\conexao.php');
        //buscar cargo a ser alterado
            try {
                $stmt = $conexao->prepare("SELECT * FROM g4_ingrediente WHERE id_Ingrediente= ?");
                $stmt->bindParam(1, $id_Ingrediente, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $rs = $stmt->fetch(PDO::FETCH_OBJ);
                    $id_Ingrediente = $rs->$id_Ingrediente;
                    $descricao = $rs->$descricao;
                } else {echo "<p>Não foi possível executar a declaração sql</p>";
                }
            } catch (PDOException $erro) {
                echo "<p>Erro".$erro->getMessage()."</p>";
            }
        ?>
    <h1>Alterar</h1>
    <form action="" method="GET">
    

    </form>
    <br>
    <a href="../cargo/../index.php">Voltar</a>
</body>
</html>