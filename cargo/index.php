<?php 
include('../model/conexao.php');
include ('..\includes\header.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargo</title>
</head>
<body>
    <div class="row">
        <div class="panel panel-default">
            <div class="row">
                <form action="?act=save" method="POST" name="form1" class="form-horizontal" >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="panel-title">Cargo</span>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="descricao" class="col-sm-1 control-label">Descrição</label>
                                <div class="col-md-5">
                                    <input type="text" name="descricao" placeholder="Inserir" value="<?php
                                    echo (isset($descricao) && ($descricao != null || $descricao != "")) ? $descricao : '';
                                    ?>" class="form-control"/>
                                </div>
                                <button type="submit">Salvar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        try {
                            $stmt = $conexao->prepare("SELECT * FROM g4_cargo");
                            if ($stmt->execute()) {
                                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                                    echo "<tr>
                                        <td>$rs->id_Cargo</td>
                                        <td>$rs->nome</td>
                                        <td>
                                        <center>
                                        <a href='?act=upd&id='$rs->id_Cargo>Editar</a>
                                        <a href='?act=del&id='$rs->id_Cargo>Excluir</a>
                                        </center>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "Erro: Não foi possível recuperar os dados do banco de dados";
                        }
                    } catch (PDOException $erro) {
                        echo "Erro: " . $erro->getMessage();
                    }
                    ?>
                </tbody>
        </div>
    </div>
</body>
</html>