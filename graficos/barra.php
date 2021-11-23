<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');
include('../model/conexao.php');

//select -> buscar informações para alimentar o grafico
try {
    $stmt = $conexao->prepare("SELECT c.descricao, count(*) AS qtdCategorias FROM g4_receita r, 
    g4_categoria c WHERE r.id_Categoria = c.id_Categoria GROUP BY c.descricao;");
    if ($stmt->execute()) {
        $i = 0;
        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
            $descricao[]=$rs->descricao;
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
//$databary=array(12,7,16,5,7,14,9,3);

// New graph with a drop shadow
$graph = new Graph(300,200);
$graph->clearTheme();
$graph->SetShadow();

// Use a "text" X-scale
$graph->SetScale("textlin");

// Set title and subtitle
$graph->title->Set("Quantidade de receitas por categorias");

// Use built in font
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetTickLabels($descricao);

// Create the bar plot
$b1 = new BarPlot($qtdCategorias);
$b1->SetLegend("Quantidade");
//$b1->SetAbsWidth(6);
$b1->SetShadow();

// The order the plots are added determines who's ontop
$graph->Add($b1);

// Finally output the  image
$graph->Stroke();

?>
