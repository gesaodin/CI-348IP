<?php
  
  function fecha($fecha = ''){
    $mes = 'Enero';
    switch ($fecha) {
      case 'January':
        $mes="Enero";
        break;
      case 'February':
        $mes="Febrero";
        break;
      case 'March':
        $mes="Marzo";
        break;
      case 'April':
        $mes="Abril";
        break;
      case 'May':
        $mes="Mayo";
        break;
      case 'June':
        $mes="Junio";
        break;
      case 'July':
        $mes="Julio";
        break;
      case 'August':
        $mes="Agosto";
        break;
      case 'September':
        $mes="Septiembre";
        break;
      case 'October':
        $mes="Octubre";
        break;
      case 'November':
        $mes="Noviembre";
        break;
      case 'December':
        $mes="Diciembre";
        break;
      default:
        # code...
        break;
    }
    return $mes;
    
  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Formulario</title>
 <style>
table {
    font-family: arial, sans-serif;
    font-size: 12px;
    border-collapse: collapse;
    width: 800px;
}

td{
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}
th {
    border: 1px solid #dddddd;
    text-align: left;
    background-color: #dddddd; 
    padding: 8px;
}

/*tr:nth-child(even) {
    background-color: #dddddd;
}*/
</style>
</head>
<body>
 <center>
 <table>
 <tr>
   <td style="width: 70%;  border: 0px solid #dddddd;">
    <center>
     REPÚBLICA BOLIVARIANA DE VENEZUELA<BR>
     MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<BR>
     VICEMINISTERIO DE SERVICIOS, PERSONAL Y LOGISTICA<BR>
     DIRECCIÓN GENERAL DE EMPRESAS<BR>
     INSTITUTO DE PREVISIÓN SOCIAL<BR>
     DE LAS FUERZAS ARMADAS<BR>
    </center>
   </td>
   <td style="width: 30%;  border: 0px solid #dddddd; text-align: right;">
     Sistema PACE<br>
     <?php echo 'Caracas, ' . date('d') . ' de ' . fecha(date('F')) . ' de '. date('Y') ?>

   </td>
 </tr>
 </table>

 <table>
  <thead>
    <tr>
      <th colspan="7">Datos Básicos</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Cédula</td>
      <td><?php echo $Beneficiario->cedula;?>
      </td>
      <td>Número de cuenta:</td>
      <td colspan="3">
      <?php 
        echo $Beneficiario->numero_cuenta;
      ?>
      </td>

    </tr>
    <tr>
      <td>Nombre Completo</td>
      <td colspan="3"><?php echo $Beneficiario->nombres . ' ' . $Beneficiario->apellidos;?>
      </td>
      <td>Estatus</td>
      <td><?php echo $Beneficiario->estatus_descripcion; ?></td>
    </tr>
    <tr>
      <td>Componente</td>
      <td><?php echo $Beneficiario->Componente->nombre; ?>
      </td>
      <td>Grado</td>
      <td><?php echo $Beneficiario->Componente->Grado->nombre; ?></td>
      <td>Sexo</td>
      <td ><?php echo $Beneficiario->sexo; ?></td>
    </tr>
    <tr>
      <td>Fecha Ingreso</td>
      <td><?php 

          $f = explode('-',$Beneficiario->fecha_ingreso);
          
         echo $f[2] . '-' . $f[1] . '-' . $f[0];
      ?>
      </td>
      <td>Tiempo de Serv.</td>
      <td><?php 
        if ($Beneficiario->fecha_retiro != ''){
            echo $Beneficiario->tiempo_servicio_aux; 
        }else{
            echo $Beneficiario->tiempo_servicio;
        }
      ?></td>
      <td>N° Hijos</td>
      <td><?php echo $Beneficiario->numero_hijos; ?></td>
    </tr>
    <tr>
      <td>Últ. Ascenso</td>
      <td><?php 
         $f =  explode('-',$Beneficiario->fecha_ultimo_ascenso);          
         echo $f[2] . '-' . $f[1] . '-' . $f[0];
       ?>
      </td>
      <td>Estatus de N° Ascenso</td>
      <td><?php echo $Beneficiario->no_ascenso; ?></td>
      <td>St. Profesional</td>
      <td><?php echo $Beneficiario->profesionalizacion; ?></td>
    </tr>
    <tr>
     <td>Años Recon.</td>
     <td><?php echo $Beneficiario->ano_reconocido; ?>
     </td>
     <td>Meses Recon.</td>
     <td><?php echo $Beneficiario->mes_reconocido; ?></td>
     <td>Dias Recon.</td>
     <td><?php echo $Beneficiario->dia_reconocido; ?></td>
   </tr>
   <tr>
    <td>Fecha Retiro</td>
    <td colspan="5">
    <?php 
      if ($Beneficiario->fecha_retiro != ''){
        $f =  explode('-',$Beneficiario->fecha_retiro);          
        echo $f[2] . '-' . $f[1] . '-' . $f[0];
      }
    ?></td>

  </tr>

</table><br>
    
<table>
  <thead>
    <tr>
      <th colspan="7">Datos Sueldo</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Sueldo Básico</td>
      <td colspan="7"><?php echo number_format($Beneficiario->sueldo_base, 2, ',','.'); ?>
      </td>     
    </tr>

    <tr>
      <th colspan="7" style="text-align: center;">Primas</th>
    </tr>
    <tr>
      <td>Transporte</td>
      <td><?php echo number_format($Beneficiario->prima_transporte, 2, ',','.'); ?>
      </td>
      <td>Descendencia</td>
      <td>
        <?php echo number_format($Beneficiario->prima_descendencia, 2, ',','.'); ?>
      </td>
      <td>Especial</td>
      <td ><?php echo number_format($Beneficiario->prima_especial, 2, ',','.'); ?></td>
    </tr>
    <tr>
      <td>Años  de Servicio</td>
      <td><?php echo number_format($Beneficiario->prima_tiemposervicio, 2, ',','.'); ?>
      </td>
      <td>N° de Ascenso</td>
      <td><?php echo number_format($Beneficiario->prima_noascenso, 2, ',','.'); ?></td>
      <td>Profesionalización</td>
      <td><?php echo number_format($Beneficiario->prima_profesionalizacion, 2, ',','.');?></td>
    </tr>
    <tr>
      <td>Sueldo Mensual</td>
      <td><?php echo number_format($Beneficiario->sueldo_global, 2, ',','.');?>
      </td>
      <td>Alic. Bono Vac.</td>
      <td><?php echo number_format($Beneficiario->vacaciones, 2, ',','.');?></td>
      <td>Alic. Bono Fin</td>
      <td><?php echo number_format($Beneficiario->aguinaldos, 2, ',','.');?></td>
    </tr>
    <tr>
     <td>Sueldo Integral</td>
     <td colspan="5"><?php echo number_format($Beneficiario->sueldo_integral, 2, ',','.');?>
     </td>
   </tr>
</table>    

<br>
    
<table>
  <thead>
    <tr>
      <th colspan="7">Datos Asignación Antiguedad</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>A. de Antiguedad</td>
      <td><?php 
        if ($Beneficiario->fecha_retiro != ''){
            echo number_format($Beneficiario->asignacion_antiguedad_fin, 2, ',','.');
        }else{
            echo number_format($Beneficiario->asignacion_antiguedad, 2, ',','.');
        }
      ?></td>
      <td>Capital En Banco.</td>
      <td>
      <?php 
        $montoCapital = isset($Beneficiario->HistorialMovimiento[3]) ? $Beneficiario->HistorialMovimiento[3]->monto : 0;
        echo number_format( $montoCapital, 2, ',','.');

      ?></td>
      <td>Garantías</td>
      <td>
        
        <?php 
              $garantia = isset($Beneficiario->HistorialMovimiento[32]) ? $Beneficiario->HistorialMovimiento[32]->monto : 0;
              
              echo number_format($garantia, 2, ',','.');


            ?>
      </td>
      </td>     
    </tr>
    <tr>
     <td>Días Adicionales.</td>
      <td><?php 
        $diasA = isset($Beneficiario->HistorialMovimiento[31]) ? $Beneficiario->HistorialMovimiento[31]->monto : 0;
        echo number_format($diasA, 2, ',','.');?>
      </td>
      <td>Total Aportado</td>
      <td>
        
        <?php 
              $totalA = isset($Beneficiario->HistorialMovimiento[3]) ? $Beneficiario->HistorialMovimiento[3]->monto : 0;
              $disponible = $totalA + $diasA + $garantia;
              echo number_format($disponible, 2, ',','.');


            ?></td>
      </td>
      <td>Saldo Disponible</td>
      <td><?php 

              //$anticipo = isset($Beneficiario->Calculo['anticipos_aux']) ? $Beneficiario->Calculo['anticipos_aux'] : 0;
              //$disponible = ($montoCapital - $anticipo) + $garantia;
              echo $Beneficiario->Calculo['saldo_disponible'];
              


            ?></td>
    </tr>
    <tr>
      <td>Diferencia A.A.</td>
      <td><?php 
              if ($Beneficiario->fecha_retiro != ''){
                 $diferencia = $Beneficiario->Calculo['asignacion_diferencia'];
                 echo $diferencia;
              }else{
                 $diferencia = $Beneficiario->Calculo['diferencia_AA'];
                 echo $diferencia;  
              }
          ?>
      </td>
      <td>Fecha Ultimo Dep.</td>
      <td><?php 
          echo $Beneficiario->Calculo['fecha_ultimo_deposito'];
        ?></td>
      <td>% Aportado</td>
      <td >
        
          <?php 
              $cancelado = ($montoCapital + $garantia + $diasA)/ $Beneficiario->asignacion_antiguedad;
              echo number_format($cancelado * 100, 2, ',','.') ;
            ?>

      </td>
    </tr>
    <tr>
      <td>Embargo</td>
      <td>
      <?php 
          $monto = 0;
          if(isset($Beneficiario->MedidaJudicial[1])){
            if($Beneficiario->MedidaJudicial[1]->monto > 0){
              $monto = $Beneficiario->MedidaJudicial[1]->monto;
            }else{
             $monto = ($Beneficiario->asignacion_antiguedad * $Beneficiario->MedidaJudicial[1]->porcentaje)/100;
            }
          }
       
          echo number_format($monto, 2, ',','.')
        ?>
      </td>
      <td>Anticipos.</td>
      <td><?php 
        $anticipo = isset($Beneficiario->Calculo['anticipos_aux']) ? $Beneficiario->Calculo['anticipos_aux'] : 0;
        echo number_format($anticipo, 2, ',','.');

      ?></td>
      <td>Fecha U. Anticipo</td>
      <td>
      <?php 
        $fecha = isset($Beneficiario->HistorialMovimiento[5]) ? $Beneficiario->HistorialMovimiento[5]->fecha : '';
        if ($fecha != ''){
          $f = explode('-', $fecha); 
          echo $f[2] . '-' . $f[1] . '-' . $f[0];
        }
      ?></td>
    </tr>
    <tr>
     <td>Comisión S.</td> 
     <td><?php 
      //se incluyo para que mostrara la comision de servicio en la hoja de vida
        $comision = isset($Beneficiario->Calculo['comision_servicios']) ? $Beneficiario->Calculo['comision_servicios'] : 0;
        echo $comision;

      ?></td>
     <td colspan="5">
     </td>
   </tr>
    <tr>
      <td>Total Calculados.</td>
      <td>
      </td>
      <td>Total Cancelados</td>
      <td></td>
      <td>Total Adeudado</td>
      <td></td>
    </tr>
    <tr>
     <td>Fecha Ultimo Deposito</td>
     <td><?php 
       //$fecha = isset($Beneficiario->HistorialMovimiento[3]) ? $Beneficiario->HistorialMovimiento[3]->fecha : '';
        //echo $fecha;
     ?>
     </td>
      <td>Embargo</td>
      <td colspan="3">
        
      </td>
   </tr>
</table> 




<br><br><br>

<br><br><br>

<br><br><br>
<br><br><br>




 <table>
 <tr>
   <td style="width: 70%;  border: 0px solid #dddddd;">
    <center>
     REPÚBLICA BOLIVARIANA DE VENEZUELA<BR>
     MINISTERIO DEL PODER POPULAR PARA LA DEFENSA<BR>
     VICEMINISTERIO DE SERVICIOS<BR>
     DIRECCIÓN GENERAL DE EMPRESAS Y SERVICIOS<BR>
     INSTITUTO DE PREVISIÓN SOCIAL<BR>
     DE LA FUERZA ARMADA<BR>
    </center>
   </td>
   <td style="width: 30%;  border: 0px solid #dddddd; text-align: right;">
     Sistema PACE<br>
     <?php echo 'Caracas, ' . date('d') . ' de ' . fecha(date('F')) . ' de '. date('Y') ?>

   </td>
 </tr>
 </table>

 <table>
  <thead>
    <tr>
      <th colspan="7">Datos Básicos</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Cédula</td>
      <td><?php echo $Beneficiario->cedula;?>
      </td>
      <td>Número de cuenta:</td>
      <td colspan="3">
      <?php 
        echo $Beneficiario->numero_cuenta;
      ?>
      </td>

    </tr>
    <tr>
      <td>Nombre Completo</td>
      <td colspan="3"><?php echo $Beneficiario->nombres . ' ' . $Beneficiario->apellidos;?>
      </td>
      <td>Estatus</td>
      <td><?php echo $Beneficiario->estatus_descripcion; ?></td>
    </tr>
    <tr>
      <td>Componente</td>
      <td><?php echo $Beneficiario->Componente->nombre; ?>
      </td>
      <td>Grado</td>
      <td><?php echo $Beneficiario->Componente->Grado->nombre; ?></td>
      <td>Sexo</td>
      <td ><?php echo $Beneficiario->sexo; ?></td>
    </tr>
    <tr>
      <td>Fecha Ingreso</td>
      <td><?php 

          $f = explode('-',$Beneficiario->fecha_ingreso);
          
         echo $f[2] . '-' . $f[1] . '-' . $f[0];
      ?>
      </td>
      <td>Tiempo de Serv.</td>
      <td><?php echo $Beneficiario->tiempo_servicio; ?></td>
      <td>N° Hijos</td>
      <td><?php echo $Beneficiario->numero_hijos; ?></td>
    </tr>
    <tr>
      <td>Últ. Ascenso</td>
      <td><?php 
         $f =  explode('-',$Beneficiario->fecha_ultimo_ascenso);          
         echo $f[2] . '-' . $f[1] . '-' . $f[0];
       ?>
      </td>
      <td>Estatus de N° Ascenso</td>
      <td><?php echo $Beneficiario->no_ascenso; ?></td>
      <td>St. Profesional</td>
      <td><?php echo $Beneficiario->profesionalizacion; ?></td>
    </tr>
    <tr>
     <td>Años Recon.</td>
     <td><?php echo $Beneficiario->ano_reconocido; ?>
     </td>
     <td>Meses Recon.</td>
     <td><?php echo $Beneficiario->mes_reconocido; ?></td>
     <td>Dias Recon.</td>
     <td><?php echo $Beneficiario->dia_reconocido; ?></td>
   </tr>
   <tr>
    <td>Fecha Retiro</td>
    <td colspan="5">
    <?php 
      if ($Beneficiario->fecha_retiro != ''){
        $f =  explode('-',$Beneficiario->fecha_retiro);          
        echo $f[2] . '-' . $f[1] . '-' . $f[0];
      }
    ?></td>

  </tr>

</table><br>
    

<?php
  
  $sCabecera = '<table style="width:50%">
  <thead>
    <tr>
      <th colspan="7">Movimientos</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th colspan="7"><center>Anticipos</center></th>
    </tr>
    <tr><td style="width: 30%">Fecha</td><td style="width: 70%"><center>Monto</center></td></tr>';

  $sCuerpo = '';

  $sPie = '
  </tbody>
  </table>';
  $iCant = count($Beneficiario->HistorialOrdenPagos);
  if($iCant > 0){
    foreach ($Beneficiario->HistorialOrdenPagos as $k => $v) {
      $f =  explode('-',$v->fecha);    
      if($v->estatus == 100){        
        $sCuerpo .= '<tr><td>' . $f[2] . '-' . $f[1] . '-' . $f[0] . 
          '</td><td style="text-align: right;">' . number_format($v->monto, 2, ',','.') . '</td></tr>';
      }
    
    }

    echo $sCabecera . $sCuerpo . $sPie;
  }
  

?>



<br><br><br><br><br><br><br>


<table>
  <tr>
    <td style="border:0px; width: 50%; text-align: center;"><b>
      OMAR CASTRO RODRIGUEZ<BR>
      TCNEL.<BR>
      JEFE DEL DPTO. DE FIDEICOMISO<BR>
      </b>
    </td>
    <td style="border:0px; width: 50%; text-align: center;"><b>
      EDUARDO JOSE MARTINEZ SALAS<BR>
      CNEL.<BR>
      GERENTE DE BIENESTAR Y SEGURIDAD SOCIAL
      </b>
    </td>
  </tr>
</table>
</center>

  <br><br>
  <center>
    <button onclick="imprimir()" id="btnPrint">Imprimir Reporte</button>
  </center>

  <script language="Javascript">
    function imprimir(){
        document.getElementById('btnPrint').style.display = 'none';
        window.print();
        window.close();
    }
  </script>

</body>
</html>
