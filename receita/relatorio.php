<?php
    require('../../../fpdf184/fpdf.php');

    class PDF extends FPDF
    {
        public function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link=''){
            $txt = utf8_decode($txt);
            parent::Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
        }
        // Load data
        function LoadData()
        {
        require('../model/conexao.php');
            // Read file lines
            try {
                $query = "select * from g4_receita";
                $stmt = $conn->prepare($query);
                $stmt->execute();

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }
            } catch(PDOException $e) {
                echo "Error: ".$e->getMessage();
            }
            return $data;
        }

        // Colored table
        function FancyTable($header, $data)
        {
            // Colors, line width and bold font
            $this->SetFillColor(255,0,0);
            $this->SetTextColor(255);
            $this->SetDrawColor(128,0,0);
            $this->SetLineWidth(.3);
            $this->SetFont('','B');
            // Header
            $w = array(40, 40, 50, 250, 45, 30, 30);
            for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
            $this->Ln();
            // Color and font restoration
            $this->SetFillColor(224,235,255);
            $this->SetTextColor(0);
            $this->SetFont('');
            // Data
            $fill = false;
            foreach($data as $row)
            {
                $this->Cell($w[0],6,number_format($row["id_Receita"]),'LR',0,'C',$fill);
                $this->Cell($w[1],6,$row["nome"],'LR',0,'C',$fill);
                $this->Cell($w[2],6,$row["data_criacao"],'LR',0,'C',$fill);
                $this->Cell($w[3],6,$row["modo_preparo"],'LR',0,'C',$fill);
                $this->Cell($w[4],6,number_format($row["qtde_porcao"]),'LR',0,'C',$fill);
                $this->Cell($w[5],6,$row["id_Categoria"],'LR',0,'C',$fill);
                $this->Cell($w[6],6,$row["id_Funcionario"],'LR',0,'C',$fill);
                $this->Ln();
                $fill = !$fill;
            }
            // Closing line
            $this->Cell(array_sum($w),0,'','T');
        }
    }

    $pdf = new PDF();
    // Column headings
    $header = array('Id Receita', 'Receita', 'Data de criação', 'Mode de preparo', 'Quantidade por porção', 'Categoria', 'Funcionário');
    // Data loading
    $data = $pdf->LoadData();
    $pdf->SetFont('Arial','',14);
    $pdf->AddPage();
    $pdf->FancyTable($header,$data);
    $pdf->Output();
?>