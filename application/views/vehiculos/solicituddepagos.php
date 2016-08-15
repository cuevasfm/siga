<?php
/* ! 
  @function num2letras ()
  @abstract Dado un n?mero lo devuelve escrito.
  @param $num number - N?mero a convertir.
  @param $fem bool - Forma femenina (true) o no (false).
  @param $dec bool - Con decimales (true) o no (false).
  @result string - Devuelve el n?mero escrito en letra.

 */

function num2letras($num, $fem = false, $dec = true) {
    $matuni[2] = "dos";
    $matuni[3] = "tres";
    $matuni[4] = "cuatro";
    $matuni[5] = "cinco";
    $matuni[6] = "seis";
    $matuni[7] = "siete";
    $matuni[8] = "ocho";
    $matuni[9] = "nueve";
    $matuni[10] = "diez";
    $matuni[11] = "once";
    $matuni[12] = "doce";
    $matuni[13] = "trece";
    $matuni[14] = "catorce";
    $matuni[15] = "quince";
    $matuni[16] = "dieciseis";
    $matuni[17] = "diecisiete";
    $matuni[18] = "dieciocho";
    $matuni[19] = "diecinueve";
    $matuni[20] = "veinte";
    $matunisub[2] = "dos";
    $matunisub[3] = "tres";
    $matunisub[4] = "cuatro";
    $matunisub[5] = "quin";
    $matunisub[6] = "seis";
    $matunisub[7] = "sete";
    $matunisub[8] = "ocho";
    $matunisub[9] = "nove";

    $matdec[2] = "veint";
    $matdec[3] = "treinta";
    $matdec[4] = "cuarenta";
    $matdec[5] = "cincuenta";
    $matdec[6] = "sesenta";
    $matdec[7] = "setenta";
    $matdec[8] = "ochenta";
    $matdec[9] = "noventa";
    $matsub[3] = 'mill';
    $matsub[5] = 'bill';
    $matsub[7] = 'mill';
    $matsub[9] = 'trill';
    $matsub[11] = 'mill';
    $matsub[13] = 'bill';
    $matsub[15] = 'mill';
    $matmil[4] = 'millones';
    $matmil[6] = 'billones';
    $matmil[7] = 'de billones';
    $matmil[8] = 'millones de billones';
    $matmil[10] = 'trillones';
    $matmil[11] = 'de trillones';
    $matmil[12] = 'millones de trillones';
    $matmil[13] = 'de trillones';
    $matmil[14] = 'billones de trillones';
    $matmil[15] = 'de billones de trillones';
    $matmil[16] = 'millones de billones de trillones';

    //Zi hack
    $float = explode('.', $num);
    $num = $float[0];

    $num = trim((string) @$num);
    if ($num[0] == '-') {
        $neg = 'menos ';
        $num = substr($num, 1);
    } else
        $neg = '';
    while ($num[0] == '0')
        $num = substr($num, 1);
    if ($num[0] < '1' or $num[0] > 9)
        $num = '0' . $num;
    $zeros = true;
    $punt = false;
    $ent = '';
    $fra = '';
    for ($c = 0; $c < strlen($num); $c++) {
        $n = $num[$c];
        if (!(strpos(".,'''", $n) === false)) {
            if ($punt)
                break;
            else {
                $punt = true;
                continue;
            }
        } elseif (!(strpos('0123456789', $n) === false)) {
            if ($punt) {
                if ($n != '0')
                    $zeros = false;
                $fra .= $n;
            } else
                $ent .= $n;
        } else
            break;
    }
    $ent = '     ' . $ent;
    if ($dec and $fra and ! $zeros) {
        $fin = ' coma';
        for ($n = 0; $n < strlen($fra); $n++) {
            if (($s = $fra[$n]) == '0')
                $fin .= ' cero';
            elseif ($s == '1')
                $fin .= $fem ? ' una' : ' un';
            else
                $fin .= ' ' . $matuni[$s];
        }
    } else
        $fin = '';
    if ((int) $ent === 0)
        return 'Cero ' . $fin;
    $tex = '';
    $sub = 0;
    $mils = 0;
    $neutro = false;
    while (($num = substr($ent, -3)) != '   ') {
        $ent = substr($ent, 0, -3);
        if (++$sub < 3 and $fem) {
            $matuni[1] = 'una';
            $subcent = 'as';
        } else {
            $matuni[1] = $neutro ? 'un' : 'uno';
            $subcent = 'os';
        }
        $t = '';
        $n2 = substr($num, 1);
        if ($n2 == '00') {
            
        } elseif ($n2 < 21)
            $t = ' ' . $matuni[(int) $n2];
        elseif ($n2 < 30) {
            $n3 = $num[2];
            if ($n3 != 0)
                $t = 'i' . $matuni[$n3];
            $n2 = $num[1];
            $t = ' ' . $matdec[$n2] . $t;
        }else {
            $n3 = $num[2];
            if ($n3 != 0)
                $t = ' y ' . $matuni[$n3];
            $n2 = $num[1];
            $t = ' ' . $matdec[$n2] . $t;
        }
        $n = $num[0];
        if ($n == 1) {
            $t = ' ciento' . $t;
        } elseif ($n == 5) {
            $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
        } elseif ($n != 0) {
            $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
        }
        if ($sub == 1) {
            
        } elseif (!isset($matsub[$sub])) {
            if ($num == 1) {
                $t = ' mil';
            } elseif ($num > 1) {
                $t .= ' mil';
            }
        } elseif ($num == 1) {
            $t .= ' ' . $matsub[$sub] . '?n';
        } elseif ($num > 1) {
            $t .= ' ' . $matsub[$sub] . 'ones';
        }
        if ($num == '000')
            $mils ++;
        elseif ($mils != 0) {
            if (isset($matmil[$sub]))
                $t .= ' ' . $matmil[$sub];
            $mils = 0;
        }
        $neutro = true;
        $tex = $t . $tex;
    }
    $tex = $neg . substr($tex, 1) . $fin;
    //Zi hack --> return ucfirst($tex);
    $end_num = ucfirst($tex) . ' pesos ' . $float[1] . '/100 M.N.';
    return $end_num;
}
?> 
<br>
<div class="col-xs-12">
    <div class="col-xs-3" >
        <img src="<?php echo base_url(); ?>media/logo_inca.jpg" width="180px">
    </div>
    <div class="col-xs-5" ><br>
        <p class="text-center" style="font-size: 20px; color: #770b4b "><strong>SOLICITUD GENERAL DE PAGOS</strong></p>
    </div>
    <div class="col-xs-4" >
        <strong>PROYECTO:</strong> <?php echo $proyecto; ?>
    </div>
</div>
<div class="col-xs-12">
    <br><strong>SOLICITUD DE PAGOS:</strong> <?php echo $solicitudde; ?><br>
</div>
<div class="col-xs-12">
    <div class="col-xs-8" >
        <br> <strong>BENEFICIARIO:</strong> <?php echo $beneficiario; ?><br>
        <strong>CANTIDAD EN LETRA:</strong> <?php echo strtoupper(num2letras($costo)); ?><br>
        <strong>RFC:</strong> <?php echo $rfc; ?><br>
        <strong>CLABE INTERBANCARIA:</strong> <?php echo $clabe; ?>
    </div>
    <div class="col-xs-4" >
        <br><strong>FECHA:</strong> <?php echo $fecha; ?><br>
        <strong>IMPORTE:</strong> <?php echo money_format('%= (#6.2n', $costo); ?><br>
        <strong>BANCO:</strong> <?php echo $banco; ?> <br>
    </div>
</div>
<div class="col-xs-12">
    <table class="table table-bordered" style="font-size: 12px">
        <tr>
            <th style="width: 33%; background-color: #770b4b !important; color: white !important;">CONCEPTO</th>
            <th style="width: 33%; background-color: #770b4b !important; color: white !important;" >NOMBRE Y FIRMA DE SOLICITANTE</th>
            <th style="width: 34%; background-color: #770b4b !important; color: white !important;">NOMBRE Y FIRMA DE AUTORIZACIÓN</th>
        </tr>  
        <tr>
            <td><?php echo mb_strtoupper($concepto); ?> </td>
            <td><?php echo mb_strtoupper($nombre); ?></td>
            <td></td>
        </tr>
    </table>

</div>
<div class="col-xs-12">
    <table class="table table-bordered" style="font-size: 12px">
        <caption class="text-center" style="width: 100%; font-size: 16px; background-color: #770b4b !important; color: white !important;">USO EXCLUSIVO DE LA GERENCIA CONTABLE</caption>
        <tr>
            <th style="width: 10%; background-color: #770b4b !important; color: white !important;">CUENTA</th>
            <th style="width: 10%; background-color: #770b4b !important; color: white !important;">SUBCUENTA</th>
            <th style="width: 10%; background-color: #770b4b !important; color: white !important;">S/S/CTA</th>
            <th style="width: 40%; background-color: #770b4b !important; color: white !important;">CONCEPTO</th>
            <th style="width: 10%; background-color: #770b4b !important; color: white !important;">PARCIAL</th>
            <th style="width: 10%; background-color: #770b4b !important; color: white !important;">DEBE</th>
            <th style="width: 10%; background-color: #770b4b !important; color: white !important;">HABER</th>
        </tr>  
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>
<div class="col-xs-12">
    <table class="table table-bordered" style="font-size: 12px">
        <tr>
            <th style="width: 20%; background-color: #770b4b !important; color: white !important;">CONTABILIZÓ:</th>
            <th style="width: 20%; background-color: #770b4b !important; color: white !important;">REVISÓ:</th>
            <th style="width: 20%; background-color: #770b4b !important; color: white !important;">AUTORIZÓ:</th>
            <th style="width: 20%; background-color: #770b4b !important; color: white !important;">FECHA:</th>
            <th style="width: 20%; background-color: #770b4b !important; color: white !important;">NO. PÓLIZA:</th>
        </tr>  
        <tr>
            <td><br></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

</div>