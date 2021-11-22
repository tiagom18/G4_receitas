<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');
include('../model/conexao.php');

try {
    $stmt = $conexao->prepare("SELECT c.descricao, count(*) AS qtdCategorias FROM g4_receita r, 
    g4_categoria c WHERE r.id_Categoria = c.id_Categoria GROUP BY c.descricao");
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

$datay=$qtdCategorias;

// Create the graph. These two calls are always required
$graph = new Graph(300,200);
$graph->clearTheme();
$graph->SetScale("textlin");

// Add a drop shadow
$graph->SetShadow();

// Adjust the margin a bit to make more room for titles
$graph->img->SetMargin(40,30,20,40);

// Create a bar pot
$bplot = new BarPlot($qtdCategorias);
$graph->Add($bplot);

// Setup the titles
$graph->title->Set("Quantidade de receitas por categorias");
$graph->xaxis->title->Set("X-title");
$graph->yaxis->title->Set("Y-title");

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Display the graph
$graph->Stroke();
?>
