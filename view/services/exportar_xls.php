 <?php
include "../../controller/programacao/programacao_controller.php";

$con = new Programacao_Controller();
$programacoes = $con->Lista();

$html =
  "<table>
      <thead>
        <tr>
          <th>Criacao</th>
          <th>Solicitacao</th>
          <th>Terminal</th>
          <th>Cliente</th>
          <th>Booking</th>
          <th>Armador</th>
          <th>Produto</th>
          <th>Instrucao</th>
          <th>Porto</th>
          <th>Navio</th>
          <th>Qtde</th>
          <th>Cntr</th>
          <th>DL Cliente</th>
          <th>Programador</th>
          <th>Ocorrencia</th>
          <th>Qtd</th>
        </tr>
      </thead>                          
  <tbody>";

foreach ($programacoes as $k => $programacao){
    $html .= "<tr>                             
        <td>". $programacao['dcProgramacao']."</td>
        <td>". $programacao['dsProgramacao']."</td>
        <td>". $programacao['sgTerminal']."</td>
        <td>". $programacao['nmGrupoCliente']."</td>
        <td>". $programacao['bkProgramacao']."</td>
        <td>". $programacao['sgArmador']."</td>
        <td>". $programacao['nmProduto']."</td>
        <td>". $programacao['inProgramacao']."</td>
        <td>". $programacao['nmPorto']."</td>
        <td>". $programacao['nvProgramacao']."</td>
        <td>". $programacao['qtProgramacao']."</td>
        <td>". $programacao['nmTipoContainer']."</td>
        <td>". $programacao['dlcProgramacao']."</td>
        <td>". ucwords($programacao['nmFuncionario'])."</td>
        <td>". $programacao['ocorrencia']."</td>
        <td>". $programacao['quantidade']."</td>
      </tr>";
}
    $html .= "</tbody></table>";

 // Determina que o arquivo é uma planilha do Excel
 header("Content-type: application/vnd.ms-excel");  

 // Força o download do arquivo
 header("Content-type: application/force-download"); 

 // Seta o nome do arquivo
 header("Content-Disposition: attachment; filename=lista_programacao.xls");
 header("Pragma: no-cache");

 // Imprime o conteúdo da nossa tabela no arquivo que será gerado
 echo $html;


    