<?php
    function readCargo($conexao, $id_Cargo){
        $rs = array();
        try {
            $stmt = $conexao->prepare("SELECT * FROM g4_cargo WHERE id_Cargo = :id");
            $stmt->bindParam(":id", $id_Cargo, PDO::PARAM_INT); 
            if ($stmt->execute()) {
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    return $rs;
                }
            } else {
           echo "Erro: Não foi possível recuperar os dados do banco de dados";
            }
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
    }
?>