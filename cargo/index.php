<?php 
include('../model/conexao.php');
include ('..\includes\header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargo</title>
</head>
<body>
    <div class="row">
        <div class="panel panel-default">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    try {$stmt = $conexao->prepare("SELECT * FROM g4_cargo");
                        if ($stmt->execute()) {
                            while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                ?>
                                <tr>
                                <td><?php echo $rs->id_Cargo; ?></td>
                                <td><?php echo $rs->nome; ?></td>
                                <td><center>
                                <a href="?act=upd&id=<?php echo $rs->id; ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span> Editar</a>
                                <a href="?act=del&id=<?php echo $rs->id; ?>" class="btn btn-danger btn-xs" ><span class="glyphicon glyphicon-remove"></span> Excluir</a>
                                </center>
                                </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "Erro: Não foi possível recuperar os dados do banco de dados";
                        }
                    } catch (PDOException $erro) {
                        echo "Erro: " . $erro->getMessage();
                    }

                        ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>