<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_pie.php');

include('../model/conexao.php');

try {
    $stmt = $conexao->prepare("select c.descricao, count(*) as qtdcategorias
    from g4_receita r,
        g4_categoria c 
    where r.id_Categoria = c.id_Categoria
    group by c.descricao");
    if ($stmt->execute()) {
        $i = 0;
        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
            $descricao[]=$rs->descriacao;
            $qtdCategorias[]=$rs->qtdCategorias;
            $i++;
        }
    } else {
echo "Erro: Não foi possível recuperar os dados do banco de dados";
    }
} catch (PDOException $erro) {
    echo "Erro: " . $erro->getMessage();
}

// Some data
$data = array(40,21,17,14,23);

// Create the Pie Graph. 
$graph = new PieGraph(350,250);

$theme_class="DefaultTheme";
//$graph->SetTheme(new $theme_class());

// Set A title for the plot
$graph->title->Set("A Simple Pie Plot");
$graph->SetBox(true);

// Create
$p1 = new PiePlot($data);
$graph->Add($p1);

$p1->ShowBorder();
$p1->SetColor('black');
$p1->SetSliceColors(array('#1E90FF','#2E8B57','#ADFF2F','#DC143C','#BA55D3'));
$graph->Stroke();

?>


