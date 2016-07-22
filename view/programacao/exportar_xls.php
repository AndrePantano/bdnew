 <?php
include "../../controller/programacao/programacao_controller.php";

$con = new Programacao_Controller();
$programacoes = $con->getProgramacoes();

$html =
  "<table border='1' style='background-color:transparent;'>
    <thead>
      <tr>
        <th> Id                       </th>
        <th> Data Criacao             </th>
        <th> Data Solicitacao         </th>
        <th> Terminal                 </th>
        <th> Cliente                  </th>
        <th> Booking                  </th>
        <th> Armador                  </th>
        <th> Produto                  </th>
        <th> Instrucao                </th>
        <th> Porto                    </th>
        <th> Navio                    </th>
        <th> Quantidade               </th>
        <th> Tipo Container           </th>
        <th> DeadLine Cliente         </th>
        <th> Programador              </th>
      </tr>
    </thead>
    <tbody>";

    foreach ($programacoes as $programacao){
      $html .=
      "<tr>
        <td>".  $programacao->getIdProgramacao()                                ."</td>
        <td>".  date("d/m/Y" , strtotime($programacao->getDcProgramacao()))     ."</td>
        <td>".  date("d/m/Y" , strtotime($programacao->getDsProgramacao()))     ."</td>
        <td>".  $programacao->getTerminal()->getSgTerminal()                    ."</td>
        <td>".  $programacao->getGrupoCliente()->getNmGrupoCliente()            ."</td>
        <td>".  $programacao->getBkProgramacao()                                ."</td>
        <td>".  $programacao->getArmador()->getSgArmador()                      ."</td>
        <td>".  $programacao->getProduto()->getNmProduto()                      ."</td>
        <td>".  $programacao->getInProgramacao()                                ."</td>
        <td>".  $programacao->getPorto()->getNmPorto()                          ."</td>
        <td>".  $programacao->getNvProgramacao()                                ."</td>
        <td>".  $programacao->getQtProgramacao()                                ."</td>
        <td>".  $programacao->getTipoContainer()->getNmTipoContainer()          ."</td>
        <td>".  date("d/m/Y H:i", strtotime($programacao->getDlcProgramacao())) ."</td>
        <td>".  $programacao->getFuncionario()->getNmFuncionario()              ."</td>
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


    