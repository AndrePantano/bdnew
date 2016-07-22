<?php 
$url = explode("/", $_SERVER["REQUEST_URI"]);
?>

<div class="col-sm-3">
	
	<h3 class="page-header">&nbsp;</h3>
	
	<div class="panel panel-default">
		<div class="panel-heading">Painel Configura&ccedil;&atilde;o</div>		
		<div class="list-group">
			<a href="#" 			class="list-group-item <?= $url[3] == "corredores"? 'active':''?> disabled"><i class="fa fa-2x fa-road"></i> Corredores </a>
			<a href="../terminais/" class="list-group-item <?= $url[3] == "terminais"? 	'active':''?>"><i class="fa fa-2x fa-industry"></i> Terminais </a>
			<a href="../clientes/" 	class="list-group-item <?= $url[3] == "clientes"? 	'active':''?>"><i class="fa fa-2x fa-users"></i> Clientes </a>
			<a href="#" 			class="list-group-item <?= $url[3] == "portos"? 	'active':''?> disabled"><i class="fa fa-2x fa-ship"></i> Portos </a>
			<a href="#" 			class="list-group-item <?= $url[3] == "produtos"? 	'active':''?> disabled"><i class="fa fa-2x fa-product-hunt"></i> Produtos </a>
			<?php if($con->getIdFuncaoFuncionarioSessao() == 1 ):?>
				<a href="../funcionarios/" class="list-group-item <?= $url[3] == "funcionarios"? 'active':''?>"><i class="fa fa-2x fa-male"></i> Funcion&aacute;rios </a>
			<?php endif; ?>
		</div>
		<div class="panel-footer"></div>		
	</div>
</div>

