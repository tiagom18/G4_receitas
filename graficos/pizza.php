<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_pie.php');
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
$data = array(40,60,21,33);

$graph = new PieGraph(300,200);
$graph->clearTheme();
$graph->SetShadow();

$graph->title->Set("Quantidade de receitas por categorias");
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$p1 = new PiePlot($qtdCategorias);
$p1->SetLegends($descricao);
$p1->SetCenter(0.4);

$graph->Add($p1);
$graph->Stroke();

?>
