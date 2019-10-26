<?php
include('fpdf/fpdf.php');
class PDF extends FPDF
{
	var $widths; 
	var $aligns; 
	
	function datosOrden($datosOrden,$depto){
		$this->Image('images/bannerPDF.jpg' , 25 ,10, 228 ,20 ,'JPG', 'http://www.tv3pue.net');
		$this->Ln();
		$this->SetXY(35,33);
		$this->SetFont('Arial','B',10);
		$cont = 33;
		$this->SetTextColor(51, 64, 105); //Letra color azul televisa
        $this->SetFillColor(255, 255, 255); //Fondo blanco
		$this->CellFitSpace(50,5.5, utf8_decode('Departamento solicitante:'),0, 0 , 'L',true );
		$this->SetFont('Arial','',10);
		$this->CellFitSpace(52,5.5, utf8_decode($depto[0]),0,0, 'L',true );
		$this->CellFitSpace(54,5.5, utf8_decode(' '),0, 0 , 'L',true );
		$this->SetFont('Arial','B',10);
		$this->CellFitSpace(13,5.5, utf8_decode('Folio:'),0, 0 , 'L',true );
		$this->SetFont('Arial','',10);
		$this->CellFitSpace(17,5.5, utf8_decode($_SESSION['idOrden3legida']),0,0, 'L',true );
		$this->Ln();	//salto de linea para generar otra fila
		$cont = $cont+5.5;
		$this->SetXY(35,$cont);
		$this->SetFont('Arial','B',10);
		$this->CellFitSpace(24,5.5, utf8_decode('Solicitante:'),0, 0 , 'L',true );
		$this->SetFont('Arial','',10);
		$this->CellFitSpace(88,5.5, utf8_decode($datosOrden[0]),0,0, 'L',true );
		$this->CellFitSpace(30,5.5, utf8_decode(' '),0, 0 , 'L',true );
		$this->SetFont('Arial','B',10);
		$this->CellFitSpace(27,5.5, utf8_decode('Fecha y hora:'),0, 0 , 'L',true );
		$this->SetFont('Arial','',10);
		$this->CellFitSpace(38,5.5, utf8_decode($datosOrden[1]),0,0, 'L',true );
		$this->Ln();	//salto de linea para generar otra fila
		$cont = $cont+5.5;
		$this->SetXY(35,$cont);
		$this->SetFont('Arial','B',10);
		$this->CellFitSpace(43,5.5, utf8_decode('Correo de solicitante:'),0, 0 , 'L',true );
		$this->SetFont('Arial','',10);
		$this->CellFitSpace(164,5.5, utf8_decode($datosOrden[3]),0,0, 'L',true );
	}
	
	
	/*** Datos para orden supervisor de compras ****/
	function datosOrdenSupCompras($datosOrden){
		$this->Image('images/bannerPDF.jpg' , 25 ,10, 228 ,20 ,'JPG', 'http://www.rockruz.net/compras2');
		$this->Ln();
		$this->SetXY(35,33);
		$this->SetFont('Arial','B',10);
		$cont = 33;
		$this->SetTextColor(51, 64, 105); //Letra color azul televisa
        $this->SetFillColor(255, 255, 255); //Fondo blanco
		$this->CellFitSpace(50,5.5, utf8_decode('Departamento solicitante:'),0, 0 , 'L',true );
		$this->SetFont('Arial','',10);
		$this->CellFitSpace(52,5.5, utf8_decode($datosOrden[4]),0,0, 'L',true );
		$this->CellFitSpace(54,5.5, utf8_decode(' '),0, 0 , 'L',true );
		$this->SetFont('Arial','B',10);
		$this->CellFitSpace(13,5.5, utf8_decode('Folio:'),0, 0 , 'L',true );
		$this->SetFont('Arial','',10);
		$this->CellFitSpace(17,5.5, utf8_decode($_SESSION['idOrden3legida']),0,0, 'L',true );
		$this->Ln();	//salto de linea para generar otra fila
		$cont = $cont+5.5;
		$this->SetXY(35,$cont);
		$this->SetFont('Arial','B',10);
		$this->CellFitSpace(24,5.5, utf8_decode('Solicitante:'),0, 0 , 'L',true );
		$this->SetFont('Arial','',10);
		$this->CellFitSpace(88,5.5, utf8_decode($datosOrden[0]),0,0, 'L',true );
		$this->CellFitSpace(30,5.5, utf8_decode(' '),0, 0 , 'L',true );
		$this->SetFont('Arial','B',10);
		$this->CellFitSpace(27,5.5, utf8_decode('Fecha y hora:'),0, 0 , 'L',true );
		$this->SetFont('Arial','',10);
		$this->CellFitSpace(38,5.5, utf8_decode($datosOrden[1]),0,0, 'L',true );
		$this->Ln();	//salto de linea para generar otra fila
		$cont = $cont+5.5;
		$this->SetXY(35,$cont);
		$this->SetFont('Arial','B',10);
		$this->CellFitSpace(43,5.5, utf8_decode('Correo de solicitante:'),0, 0 , 'L',true );
		$this->SetFont('Arial','',10);
		$this->CellFitSpace(164,5.5, utf8_decode($datosOrden[3]),0,0, 'L',true );
	}
	
    function cabeceraHorizontal()
    {
        $this->SetXY(25, 55);
        $this->SetFont('Arial','B',10);
		$this->SetFillColor(51, 64, 105);//fondo azul
		//$this->SetFillColor(229, 229, 229);
        $this->SetTextColor(255, 255, 255); //Letra color blanco
		$this->CellFitSpace(15,6, utf8_decode('No.'),1, 0 , 'C',true );
		$this->CellFitSpace(23,6, utf8_decode('Cantidad'),1, 0 , 'C',true );
		$this->CellFitSpace(19,6, utf8_decode('Unidad'),1, 0 , 'C',true );
		$this->CellFitSpace(85,6, utf8_decode('Descripción del material'),1, 0 , 'C',true );
		$this->CellFitSpace(85,6, utf8_decode('Detalle de lugar para usarse'),1, 0 , 'C',true );
    }
	
	/*** Cabecera horizontal para supervisor de compras ****/
	function cabeceraHorizontalSupCompras()
    {
        $this->SetXY(18, 55);
        $this->SetFont('Arial','B',7.5);
		$this->SetFillColor(51, 64, 105);//Fondo verde de celda
		//$this->SetFillColor(229, 229, 229);
        $this->SetTextColor(255, 255, 255); //Letra color blanco
		$this->CellFitSpace(7,6, utf8_decode('No.'),1, 0 , 'C',true );
		$this->CellFitSpace(15,6, utf8_decode('Cantidad'),1, 0 , 'C',true );
		$this->CellFitSpace(13,6, utf8_decode('Unidad'),1, 0 , 'C',true );
		$this->CellFitSpace(66,6, utf8_decode('Descripción del material'),1, 0 , 'C',true );
		$this->CellFitSpace(50,6, utf8_decode('Detalle de lugar para usarse'),1, 0 , 'C',true );
		$this->CellFitSpace(21,6, utf8_decode('No. cuenta'),1, 0 , 'C',true );
		$this->CellFitSpace(35,6, utf8_decode('Proveedor'),1, 0 , 'C',true );
		$this->CellFitSpace(18,6, utf8_decode('Precio U.'),1, 0 , 'C',true );
		$this->CellFitSpace(18,6, utf8_decode('Importe'),1, 0 , 'C',true );
    }
	
	function datosHorizontal($articulos,$datosOrden)
    {
        $this->SetXY(25,55); 
        $this->SetFont('Arial','',10); //Fuente, normal, tamaño
		$this->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $this->SetTextColor(0, 0, 0); //Color del texto: Negro
        $bandera = false; //Para alternar el relleno
		//Siendo un array tipo: $datos => $fila
        //Significa que $datos tiene 'nombre' 'apellido' 'matricula'
        //$fila tiene cada valor de los antes mencionados
		$cont = 55;
		$numeracion = 0;
        foreach($articulos as $fila)
        {
			$cont = $cont+6;
			$numeracion = $numeracion+1;
            //Atención!! el parámetro valor 0, hace que sea horizontal
			// parametro bandera dentro de cell: true o false
			// true: llena la celda con el fondo elegido
			// false: no rellena la celda
			$this->SetXY(25,$cont);
            $this->CellFitSpace(15,6, utf8_decode($numeracion),1, 0 , 'L', $bandera );
			$this->CellFitSpace(23,6, utf8_decode($fila[1]),1, 0 , 'L', $bandera );
			$this->CellFitSpace(19,6, utf8_decode($fila[2]),1, 0 , 'L', $bandera );
			$this->CellFitSpace(85,6, utf8_decode($fila[3]),1, 0 , 'L', $bandera );
			$this->CellFitSpace(85,6, utf8_decode($fila[4]),1, 0 , 'L', $bandera );
			$this->Ln();	//salto de linea para generar otra fila
			$bandera = !$bandera; //alterna el valor de la bandera
        }
		
		$cont = $cont+10;
		$this->SetXY(35,$cont);		
		//un arreglo con su medida  a lo ancho
		$this->SetWidths(array(32,175));
		$this->SetFillColor(250, 250, 250);
		//OTro arreglo pero con el contenido
		//utf8_decode es para que escriba bien los acentos.
		$this->Row(array(utf8_decode("Observaciones:"),utf8_decode($datosOrden[2])));
		$cont = $cont+36;
		$this->SetXY(80,$cont);	
		$this->SetFillColor(255, 255, 255);	
		//para firma
		$this->CellFitSpace(60,5.5, utf8_decode('___________________________'),0, 0 , 'C', true );
		$this->CellFitSpace(60,5.5, utf8_decode('___________________________'),0, 0 , 'C', true );
		$this->Ln();	//salto de linea para generar otra fila
		$cont = $cont+4.5;
		$this->SetXY(80,$cont);	
		$this->CellFitSpace(60,5.5, utf8_decode('Lic. Carlos Viveros'),0, 0 , 'C', true );
		$this->CellFitSpace(60,5.5, utf8_decode('C.P. Lourdes Gonzalez'),0, 0 , 'C', true );
		$this->Ln();	//salto de linea para generar otra fila
		$cont = $cont+4.5;
		$this->SetXY(80,$cont);	
		$this->CellFitSpace(60,5.5, utf8_decode('Compras'),0, 0 , 'C', true );
		$this->CellFitSpace(60,5.5, utf8_decode('Vo.Bo. Presupuestos'),0, 0 , 'C', true );
    }
	
	/**** *****/
	function datosHorizontalSupCompras($articulos,$datosOrden)
    {
        $this->SetXY(18,55); 
        $this->SetFont('Arial','',7.5); //Fuente, normal, tamaño
		$this->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $this->SetTextColor(0, 0, 0); //Color del texto: Negro
        $bandera = false; //Para alternar el relleno
		//Siendo un array tipo: $datos => $fila
        //Significa que $datos tiene 'nombre' 'apellido' 'matricula'
        //$fila tiene cada valor de los antes mencionados
		$cont = 55;
		$suma = 0;
		$numeracion = 0;
        foreach($articulos as $fila)
        {
			$cont = $cont+6;
			$numeracion = $numeracion+1;
            //Atención!! el parámetro valor 0, hace que sea horizontal
			// parametro bandera dentro de cell: true o false
			// true: llena la celda con el fondo elegido
			// false: no rellena la celda
			$this->SetXY(18,$cont);
            $this->CellFitSpace(7,6, utf8_decode($numeracion),1, 0 , 'L', $bandera );
			$this->CellFitSpace(15,6, utf8_decode($fila[1]),1, 0 , 'L', $bandera );
			$this->CellFitSpace(13,6, utf8_decode($fila[2]),1, 0 , 'L', $bandera );
			$this->CellFitSpace(66,6, utf8_decode($fila[3]),1, 0 , 'L', $bandera );
			$this->CellFitSpace(50,6, utf8_decode($fila[4]),1, 0 , 'L', $bandera );
			$this->CellFitSpace(21,6, utf8_decode($fila[6]),1, 0 , 'L', $bandera );
			$this->CellFitSpace(35,6, utf8_decode($fila[7]),1, 0 , 'L', $bandera );
			$this->CellFitSpace(18,6, utf8_decode($fila[5]),1, 0 , 'L', $bandera );
			$this->CellFitSpace(18,6, utf8_decode($fila[5]*$fila[1]),1, 0 , 'L', $bandera );
			$suma = $suma+($fila[5]*$fila[1]);
			$this->Ln();	//salto de linea para generar otra fila
			$bandera = !$bandera; //alterna el valor de la bandera
        }
		$cont = $cont+6;
		$this->SetXY(18,$cont);
		$this->CellFitSpace(7,6, utf8_decode(' '),0, 0 , 'L', $bandera );
		$this->CellFitSpace(15,6, utf8_decode(' '),0, 0 , 'L', $bandera );
		$this->CellFitSpace(13,6, utf8_decode(' '),0, 0 , 'L', $bandera );
		$this->CellFitSpace(58,6, utf8_decode(' '),0, 0 , 'L', $bandera );
		$this->CellFitSpace(58,6, utf8_decode(' '),0, 0 , 'L', $bandera );
		$this->CellFitSpace(21,6, utf8_decode(' '),0, 0 , 'L', $bandera );
		$this->CellFitSpace(35,6, utf8_decode(' '),0, 0 , 'L', $bandera );
		$this->SetFont('Arial','B',7.5); //Fuente, negrita, tamaño
		$this->CellFitSpace(18,6, utf8_decode('Total'),1, 0 , 'L', $bandera );
		$this->SetFont('Arial','',7.5); //Fuente, normal, tamaño
		$this->CellFitSpace(18,6, utf8_decode($suma),1, 0 , 'L', $bandera );
		
		$cont = $cont+10;
		$this->SetXY(35,$cont);		
		//un arreglo con su medida  a lo ancho
		$this->SetWidths(array(32,175));
		$this->SetFillColor(250, 250, 250);
		//OTro arreglo pero con el contenido
		//utf8_decode es para que escriba bien los acentos.
		$this->Row(array(utf8_decode("Observaciones:"),utf8_decode($datosOrden[2])));
		
		$cont = $cont+36;
		$this->SetXY(80,$cont);	
		$this->SetFillColor(255, 255, 255);	
		//para firma
		$this->CellFitSpace(60,5.5, utf8_decode('___________________________'),0, 0 , 'C', true );
		$this->CellFitSpace(60,5.5, utf8_decode('___________________________'),0, 0 , 'C', true );
		$this->Ln();	//salto de linea para generar otra fila
		$cont = $cont+5;
		$this->SetXY(80,$cont);	
		$this->CellFitSpace(60,5.5, utf8_decode('Lic. Carlos Viveros'),0, 0 , 'C', true );
		$this->CellFitSpace(60,5.5, utf8_decode('C.P. Lourdes González'),0, 0 , 'C', true );
		$this->Ln();	//salto de linea para generar otra fila
		$cont = $cont+5;
		$this->SetXY(80,$cont);	
		$this->CellFitSpace(60,5.5, utf8_decode('Compras'),0, 0 , 'C', true );
		$this->CellFitSpace(60,5.5, utf8_decode('Vo.Bo. Presupuestos'),0, 0 , 'C', true );
    }
	
	function SetWidths($w) 
	{ 
		//Set the array of column widths 
		$this->widths=$w; 
	} 
	
	function Row($data) 
	{ 
		//Calculate the height of the row 
		$nb=0; 
		for($i=0;$i<count($data);$i++) 
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i])); 
		$h=5*$nb; 
		//Issue a page break first if needed 
		$this->CheckPageBreak($h); 
		//Draw the cells of the row 
			$w=$this->widths[0]; 
			$a=isset($this->aligns[0]) ? $this->aligns[0] : 'L'; 
			//Save the current position 
			$x=$this->GetX(); 
			$y=$this->GetY();
			//Print the text 
			$this->SetFont('Arial','B',11);
			$this->MultiCell($w,5,$data[0],'0','L',true); 
			//Put the position to the right of the cell 
			$this->SetXY($x+$w,$y);
			
			$w=$this->widths[1]; 
			$a=isset($this->aligns[1]) ? $this->aligns[1] : 'J'; 
			//Save the current position 
			$x=$this->GetX(); 
			$y=$this->GetY();
			//Print the text 
			$this->SetFont('Arial','',9);
			$this->MultiCell($w,5,$data[1],'0','L',true); 
			//Put the position to the right of the cell 
			$this->SetXY($x+$w,$y);
		//Go to the next line 
		$this->Ln($h); 
	} 
	
	function CheckPageBreak($h) 
	{ 
		//If the height h would cause an overflow, add a new page immediately 
		if($this->GetY()+$h>$this->PageBreakTrigger) 
			$this->AddPage($this->CurOrientation); 
	} 
	
	function NbLines($w,$txt) 
	{ 
		//Computes the number of lines a MultiCell of width w will take 
		$cw=&$this->CurrentFont['cw']; 
		if($w==0) 
			$w=$this->w-$this->rMargin-$this->x; 
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize; 
		$s=str_replace("\r",'',$txt); 
		$nb=strlen($s); 
		if($nb>0 and $s[$nb-1]=="\n") 
			$nb--; 
		$sep=-1; 
		$i=0; 
		$j=0; 
		$l=0; 
		$nl=1; 
		while($i<$nb) 
		{ 
			$c=$s[$i]; 
			if($c=="\n") 
			{ 
				$i++; 
				$sep=-1; 
				$j=$i; 
				$l=0; 
				$nl++; 
				continue; 
			} 
			if($c==' ') 
				$sep=$i; 
			$l+=$cw[$c]; 
			if($l>$wmax) 
			{ 
				if($sep==-1) 
				{ 
					if($i==$j) 
						$i++; 
				} 
				else 
					$i=$sep+1; 
				$sep=-1; 
				$j=$i; 
				$l=0; 
				$nl++; 
			} 
			else 
				$i++; 
		} 
		return $nl;
	}
	
	//Integrando cabecera y datos en un solo método
    function tablaHorizontal($datosOrden,$articulos,$depto)
    {
       	$this->datosOrden($datosOrden,$depto);
		$this->cabeceraHorizontal();
        $this->datosHorizontal($articulos,$datosOrden);
    }
	
	
	//Integrando cabecera y datos en un solo método
    function tablaHorizontalSupCompras($datosOrden,$articulos)
    {
       	$this->datosOrdenSupCompras($datosOrden);
		$this->cabeceraHorizontalSupCompras();
        $this->datosHorizontalSupCompras($articulos,$datosOrden);
    }	
	
	
	//***** Aquí comienza código para ajustar texto *************
    //***********************************************************
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
		$str_width = 0.000001;
        $str_width=$str_width+$this->GetStringWidth($txt);
 
        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;
 
        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }
 
        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);
 
        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }
 
    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }
 
    //Patch to also work with CJK double-byte text
    function MBGetStringLength($s)
    {
        if($this->CurrentFont['type']=='Type0')
        {
            $len = 0;
            $nbbytes = strlen($s);
            for ($i = 0; $i < $nbbytes; $i++)
            {
                if (ord($s[$i])<128)
                    $len++;
                else
                {
                    $len++;
                    $i++;
                }
            }
            return $len;
        }
        else
            return strlen($s);
    }
//************** Fin del código para ajustar texto *****************
//******************************************************************
 
} // FIN Class PDF
?>