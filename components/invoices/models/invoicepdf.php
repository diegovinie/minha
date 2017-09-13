<?php

include_once ROOTDIR.'/models/locale.php';

class InvoicePdf extends FPDF
{
    public $grid = false;

    public function DrawGrid()
    {
        if($this->grid === true){
            $spacing = 5;
        }
        else{
            $spacing = $this->grid;
        }

        $this->SetDrawColor(204,255,255);
        $this->SetLineWidth(0.35);

        for($i = 0; $i < ($this->w); $i += $spacing){

            $this->Line($i, 0, $i, $this->h);
        }

        for($i = 0; $i < ($this->h); $i += $spacing){

            $this->Line(0, $i, $this->w, $i);
        }

        $this->SetDrawColor(0,0,0);

        $x = $this->GetX();
        $y = $this->GetY();
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(204, 204, 204);

        for($i = 20; $i < ($this->h); $i += 20){

            $this->SetXY(1, $i-3);
            $this->Write(4, $i);
        }

        for($i = 20; $i < (($this->w)-($this->rMargin)-10); $i += 20){
            $this->SetXY($i-1, 1);
            $this->Write(4, $i);
        }

        $this->SetXY($x, $y);
    }

    public function Header()
    {
        if($this->grid) $this->DrawGrid();
    }

    public function addBanner()
    {
        $this->Image(ROOTDIR.'/components/invoices/assets/images/banner468x60.png', 2, 7, 90);
    }

    public function addHeader($data)
    {
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(224, 235, 255);
        // Logo
        $this->SetXY(5, 5);
        //$this->Cell(70, 15, '', 1, 0, 'C');
        // Cuadro edificio
        $this->SetXY(5, 24);
        $this->Cell(57, 17, '', 1, 0, 'C');
        // Cuadro mes monto
        $this->SetXY(64, 24);
        $this->Cell(36, 17, '', 1, 0, 'C');
        // Numero de recibo
        $this->SetXY(80, 5);
        $this->Cell(20, 5, 'NUM. GEN.', 0, 0, 'C');
        $this->SetXY(80, 10);
        $this->Cell(20, 5, $data['Gen Num'], 0, 0, 'C', true);
        // Nombre del Condominio
        $this->SetXY(7, 25);
        $this->Cell(17, 5, 'INMUEBLE:', 0, 0, false);
        $this->SetXY(25, 25);
        $this->Cell(36, 5, $data['Inmueble'], 0, 0, 'C', false);
        // Nombre del propietario
        $this->SetXY(7, 30);
        $this->Cell(21, 5, 'PROPIETARIO:', 0, 0, 'L', false);
        $this->SetXY(29, 30);
        $this->Cell(
            32,
            5,
            utf8_decode(
                nombreEinicial($data['titular']['name']).' '.
                nombreEinicial($data['titular']['surname'])
            ),
            0,
            0,
            'C',
            false
        );
        // C.I. propietario
        $this->SetXY(7, 35);
        $this->Cell(10, 5, 'C.I.:', 0, 0, 'L', false);
        $this->SetXY(12, 35);
        $this->Cell(
            23,
            5,
            beautifyCI($data['titular']['ci']),
            0,
            0,
            'C',
            false
        );
        // Apartamento
        $this->SetXY(36, 35);
        $this->Cell(10, 5, 'APTO:', 0, 0, 'L', false);
        $this->SetXY(47, 35);
        $this->Cell(14, 5, $data['titular']['apt'], 0, 0, 'C', false);
        // Mes
        $this->SetXY(65, 25);
        $this->Cell(10, 5, 'MES:', 0, 0, 'L', false);
        $this->SetXY(76, 25);
        $this->Cell(23, 5, $data['Periodo'], 0, 0, 'R', false);
        // Monto total
        $this->SetXY(65, 30 );
        $this->Cell(13, 5, 'MONTO:', 0, 0, 'L', false);
        $this->SetXY(79, 30 );
        $this->Cell(
            20,
            5,
            number_format($data['monto'], 2, ',', '.'),
            0,
            0,
            'R',
            false
        );
        // Fecha de generación
        $this->SetXY(65, 35 );
        $this->Cell(12, 5, 'FECHA', 0, 0, 'L', false);
        $this->SetXY(78, 35 );
        $this->Cell(21, 5, $data['Fecha'], 0, 0, 'R', false);
    }

    public function addContent($data)
    {
        $this->SetFont('Arial', '', 6);
        $this->SetFillColor(224, 235, 255);
        // Encabezado de la tabla
        $this->SetXY(5, 45);
        $this->Cell(60, 5, 'PLANILLA DE LIQUIDACION DE GASTOS Y/O COBROS', 1, 0, 'C', true);

        $this->SetXY(65, 45);
        $this->Cell(35, 5, 'VIVIENDA TOTAL', 1, 0, 'C', true);

        $this->SetXY(5, 50);
        $this->Cell(60, 125, '', 1, 0, 'C');

        $this->SetXY(65, 50);
        $this->Cell(35, 125, '', 1, 0, 'C');

        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Tabla
        $this->SetFont('Arial','', 7);
        $this->SetXY(5, 50);

        $w = array(60, 17, 18);
        $fill = false;

        $sum = array(
            'alic' => 0.0,
            'total' => 0.0
        );
        $this->SetFont('Arial','BU', 7);
        $this->Cell($w[0], 5, utf8_decode("Descripción"), "", 0, "C", $fill);
        $this->Cell($w[1], 5, "Alic.", "", 0, "C", $fill);
        $this->Cell($w[2], 5, "Monto", "", 0, "C", $fill);
        $this->SetFont('Arial','', 7);

        $this->Ln();
        $this->SetX(5);

        foreach($data as $cat => $act){

            $this->SetFont('Arial','BU', 7);
            $this->Cell(
                $w[0],
                5,
                utf8_decode($cat),
                '',
                0,
                'L',
                $fill
            );
            $this->Ln();
            $this->SetX(5);

            //$fill = !$fill;
            foreach ($act as $name => $list) {

                $this->SetFont('Arial','B', 7);
                $this->Cell(
                    $w[0],
                    5,
                    utf8_decode($name),
                    '',
                    0,
                    'L',
                    $fill
                );
                $this->Ln();
                $this->SetX(5);
                $this->SetFont('Arial','', 7);

                foreach ($list as $row) {

                    $this->Cell(
                        $w[0],
                        5,
                        utf8_decode("   " .$row['nombre']),
                        '',
                        0,
                        'L',
                        $fill
                    );  // El Alias

                    $this->Cell(
                        $w[1],
                        5,
                        "    " .number_format($row['alic'], 2, ',', '.'),
                        '',
                        0,
                        'R',
                        $fill
                    );   // porcentaje

                    $this->Cell(
                        $w[2],
                        5,
                        "    " .number_format($row['total'], 2, ',', '.'),
                        '',
                        0,
                        'R',
                        $fill
                    ); //Total

                    //$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
                    $this->Ln();
                    $this->SetX(5);
                    //$fill = !$fill;
                    $sum['alic'] += $row['alic'];
                    $sum['total'] += $row['total'];
                }
            }

            $this->SetX(5);
        }
        // Closing line
        $this->Ln();
        $this->SetX(5);

        $this->Cell(
            $w[0],
            5,
            utf8_decode("Total:"),
            '',
            0,
            'L',
            $fill
        );  // El Alias

        $this->Cell(
            $w[1],
            5,
            "    " .number_format($sum['alic'], 2, ',', '.'),
            '',
            0,
            'R',
            $fill
        );   // porcentaje

        $this->Cell(
            $w[2],
            5,
            "    " .number_format($sum['total'], 2, ',', '.'),
            '',
            0,
            'R',
            $fill
        ); //Total
        //$this->Cell(array_sum($w),0,'','T');
    }

    public function addFooter($data)
    {
        $this->SetFont('Arial', '', 8);
        $this->SetFillColor(224, 235, 255);

        $this->SetXY(5, 180);
        $this->Cell(29, 5, 'DEUDA PREVIA', 0, 0, 'C');

        $this->SetXY(5, 185);
        $this->Cell(
            29,
            5,
            number_format($data['previo'], 2, ',', '.'),
            0,
            0,
            'C',
            true
        );

        $this->SetXY(37, 180);
        $this->Cell(30, 5, 'ESTE MES', 0, 0, 'C');

        $this->SetXY(37, 185);
        $this->Cell(
            30,
            5,
            number_format($data['actual'], 2, ',', '.'),
            0,
            0,
            'C',
            true
        );

        $this->SetXY(70, 180);
        $this->Cell(30, 5, 'TOTAL A PAGAR', 0, 0, 'C');

        $this->SetXY(70, 185);
        $this->Cell(
            30,
            5,
            number_format($data['total'], 2, ',', '.'),
            0,
            0,
            'C',
            true
        );

        $this->SetXY(90,198);
        $this->Cell(
            10,
            1,
            'Impreso: ' .date('d-m-Y H:i:s'),
            0,
            0,
            'R',
            false
        );
    }
}
