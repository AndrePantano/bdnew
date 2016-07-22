<?php
include "../../controller/volumes/volumes_controller.php";

$con = new Volumes_Controller();

if(isset($_GET["c"])){
  $con->setCorredor($_GET["c"]);
}else{
  $con->setCorredor(0);
}

$clientes = $con->getClientes();
$terminais = $con->getTerminais();
$total_orcamento = 0;
$total_programa = 0;
$total_ritmo = 0;
$total_acumulado = 0;
$total_a_realizar = 0;
$total_pre_mes = 0;

$ordem_terminal = array();

//echo "<pre>".print_r($con->getCorredor())."</pre>";
$corredor = $con->getCorredor();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <script type="text/javascript" src="../../bootstrap/js/jquery-2.1.4.min.js"></script>
  <!-- atualiza a página -->
  <!-- meta http-equiv="refresh" content="6000"--> 
  <title>Indicadores</title>
  <style type="text/css">
    body{
    background-color: #000;
    }
    h3, h4, span{
      color:#FFF;
      font-family: Arial;
    }
    hr{
      border: 0;
      height: 1px;
      background-color:#FFF;
    }
    table {
      border-collapse: collapse;
      font-family:Arial;
      font-size: 10pt;
      color:#FFF;
      margin-left:0px;
    }
    td{    
      padding: 2px 5px 2px 10px; 
    }
    .td_valor{
      text-align: right;
      padding-right: 10px;
    }
    .tr_border_bottom{
      border-bottom: 1px solid #555;
    }
    .tr_border_top{
      border-top: 1px solid #555;
    }
    #div_terminais{
      float: left;   
    }
     #div_clientes{
       float: right;   
    }
    a:link {
      text-decoration: none;
    }

    a:visited {
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    a:active {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div id="cabecalho" style="float:left; width:100%;">
      <span style="float:left;width:40%;font-size:18pt;">RELAT&Oacute;RIO VOLUME - <?= strtoupper($corredor["nmCorredor"])?></span>          
      <span style="float:left;width:60%;font-size:20pt;"><?= $con->getMesRelatorio( $clientes[0]["atualizado_em"])?></span> </h3>
      <span style="float:left;width:75%;font-size:15pt;">UNIDADE: CONTEINER</span>  
      <!--span style="float:right;width:8%;font-size:15pt;"><?= date("d/m/Y")?></span-->
      <span style="float:right;width:24%;font-size:15pt;">Atualizado em: <?= date("d/m/Y H:i",strtotime($clientes[0]["atualizado_em"]))?></span>                                    
    <hr style="float:left;width:100%;"></hr>
  </div>

  <div id="div_terminais">
      <table id="div_terminais">
        <thead>
          <th>
            <tr class="tr_border_bottom"> 
              
              <?php if(isset($_GET["c"])):?>  
                <td>TERM.</td>
              <?php else: ?>
                <td>CORREDOR</td>
              <?php endif; ?>

              <td>OR&Ccedil;AM.</td>
              <td>PROGR.</td>
              <td>RITMO</td>                  
              <td>AC.D-1</td>                  
              <td>A REAL.</td>
              <td colspan=2 align="center">TEND&Ecirc;N.</td>                  
            </tr>               
          </th>
        </thead>
        <tbody>              
          <?php foreach ($terminais as $terminal){

            $qdp = date("d") - 1; // quantidade de dias passados
            $qdm =  cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y")); // quantidade de dias no mês
            
            if($qdp == 0){ // se hoje for dia primeiro, considera como mes passado
              $qdp = date("d",strtotime("-1 day"));
              $qdm =  cal_days_in_month(CAL_GREGORIAN, date("m") - 1, date("Y")); // quantidade de dias no mês
            }

            $saldo = $terminal["ritmo"] - $terminal["programa"];

            // se o saldo for igual a zero e programa igual zero e ritmo igual a zero = cinza, caso contrário, verde
            // se o saldo for diferente zero e maior  que zero, verde, caso contrario, vermelho

            $color = "";

            if($saldo == 0){
              if($terminal["programa"] == 0 && $terminal["ritmo"] == 0){
                $color =  "696969";
              }else{
                $color = "0F0";
              }
            }else{
              if($saldo > 0){
                $color = "0F0";
              }else{
                $color = "F00";
              }
            }

            echo "<tr style='color:#".$color."';'>";                
            
            if(isset($_GET["c"])){
                echo "<td>".$terminal["terminal"]."</td>";
            }else{
                echo "<td><a href='../volumes/?c=".$terminal["idCorredor"]."' style='color:#".$color."'; '> ".strtoupper($terminal["nmCorredor"])."</a></td>";
              }
              
            echo "<td class='td_valor'>".$terminal["orcamento"]."</td>";
            echo "<td class='td_valor'>".$terminal["programa"]."</td>";
            echo "<td class='td_valor'>".$terminal["ritmo"]."</td>";                
            echo "<td class='td_valor'>".$terminal["acumulado"]."</td>";                
            $a_realizar = $terminal["ritmo"] - $terminal["acumulado"] ;                
            echo "<td class='td_valor'>".($terminal["acumulado"] > $terminal["ritmo"] ? 0 : $a_realizar)."</td>";
            
            $pre_mes = floor(($terminal["acumulado"] * $qdm) / $qdp);

            echo "<td style='text-align:right;'>".$pre_mes."</td>";
            echo "<td style='text-align:left;'>".($pre_mes < $terminal["programa"]?"<img src='imagens/caution.png'>":"")."</td>";
            echo "</tr>";
            $total_orcamento += $terminal["orcamento"];
            $total_programa += $terminal["programa"];
            $total_ritmo += $terminal["ritmo"];
            $total_acumulado += $terminal["acumulado"];
            $total_a_realizar += $a_realizar;
            $total_pre_mes += $pre_mes; 

            $ordem_terminal[$terminal["terminal"]] = $terminal["programa"];
          }

          // ORDENA A LISTA  TERMINAIS PELO PROGRAMA
          arsort($ordem_terminal);
          ?>
        </tbody>    
        <tfoot>
          <tr class='tr_border_top'>
            <td>Total</td>
            <td class='td_valor'><?= $total_orcamento?></td>
            <td class='td_valor'><?= $total_programa?></td>
            <td class='td_valor'><?= $total_ritmo?></td>                
            <td class='td_valor'><?= $total_acumulado?></td>                
            <td class='td_valor'><?= $total_a_realizar?></td>
            <td style='text-align:right;'><?= $total_pre_mes?></td>
            <td>&nbsp;</td>
          </tr>
        </tfoot>
      </table>        
  </div>

<?php if(isset($_GET["c"])):?>

  <div id="div_clientes">
    <table id="div_clientes" style="float:right;">
      <thead>
        <th>
          <tr class="tr_border_bottom">
            <!-- td>CORREDOR</td -->
            <td>TERM.</td>                
            <td>CLIENTE</td>
            <td>OR&Ccedil;AM.</td>
            <td>PROGR.</td>
            <td>RITMO</td>
            <!-- td>SALDO</td -->
            <td>AC.D-1</td>
            <td>A REAL.</td>                
          </tr>
        </th>
      </thead>
      <tbody>
        <?php 
        foreach($ordem_terminal as $chave => $valor){

          foreach ($clientes as $k => $cliente) {

            if($chave == $cliente["terminal"]){

              $saldo = $cliente["ritmo"] - $cliente["programa"];
              if($saldo > 0 || $cliente["programa"] > 0){
                
                if($k==0){$k=1;}

                echo "<tr ". ($clientes[$k-1]['terminal'] != $cliente['terminal']?"class='tr_border_top'":"") ." style='color:". ($saldo >= 0 ? "#0F0": "#F00").";'>";
                //echo "<td>".$cliente["corredor"]."</td>";
                echo "<td>".$cliente["terminal"]."</td>";
                echo "<td>".$cliente["cliente"]."</td>";
                echo "<td class='td_valor'>".$cliente["orcamento"]."</td>";
                echo "<td class='td_valor'>".$cliente["programa"]."</td>";
                echo "<td class='td_valor'>".$cliente["ritmo"]."</td>";
                //echo "<td class='td_valor'>".$saldo."</td>";
                echo "<td class='td_valor'>".$cliente["acumulado"]."</td>";
                $a_realizar = $cliente["ritmo"] - $cliente["acumulado"] ;
                echo "<td class='td_valor'>".($cliente["acumulado"] > $cliente["ritmo"] ? 0 : $a_realizar)."</td>";
                echo "</tr>";
              }
            }
          }
        }
        ?>
      </tbody>
    </table>
  </div>

<?php endif; ?>

  <div id="rodape" style="float:left; width:100%;">     
    <hr style="float:left;width:100%;"></hr>
  </div>
</body>
</html>