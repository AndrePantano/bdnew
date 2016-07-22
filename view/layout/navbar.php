
<!-- nav bar -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>            
            <!-- a class="navbar-brand" href="../home/"><img src="../layout/brado_white.png"></a -->
            <a class="navbar-brand" href="../home/"><img src="../layout/bdnew_brand.png"></a>
            </ul>
        </div>

        <?php if($con->getSessaoIniciada()): ?>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav">                    
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-th"></i> Pedras <b class="caret"></b></a>
                        <ul class="dropdown-menu">                    
                            <li><a href="../pedra/pedra_gate.php"><i class="fa fa-diamond"></i> Pedra Gate</a></li>
                            <!-- li class="disabled"><a href="#"><i class="fa fa-train"></i> Pedra Ferro</a></li -->
                            <li role="separator" class="divider"></li>
                            <li><a href="../pedra/pedra_gate_ajuste.php"><i class="fa fa-cog"></i> Ajustar Pedra Gate</a></li>
                            <!-- li class="disabled"><a href="#"><i class="fa fa-cog"></i> Ajustar Pedra Ferro</a></li -->
                            <li role="separator" class="divider"></li>
                            <!-- li><a href="../pedra/rel_01.php"><i class="fa fa-flag"></i> Relat&oacute;rios Pedra Gate</a></li -->
                            <!-- li class="disabled"><a href="#"><i class="fa fa-flag"></i> Relat&oacute;rios Pedra Ferro</a></li -->
                            <li><a href="../pedra/exportar_pedra.php"><i class="fa fa-file-excel-o"></i> Exportar Pedra Gate D até D+3</a></li>
                        </ul>
                    </li>
                   
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-th"></span> Volumes <b class="caret"></b></a>
                        <ul class="dropdown-menu">                    
                            <li><a href="../volumes/?c=2" target="_blank"><span class="glyphicon glyphicon-th"></span> Larga</a></li>                                                        
                            <li><a href="../volumes/?c=1" target="_blank"><span class="glyphicon glyphicon-th"></span> Paran&aacute;</a></li>                                                        
                            <?php if($con->getIdFuncaoFuncionarioSessao() == 1 ):?>
                            <li><a href="../volumes/?c=3" target="_blank"><span class="glyphicon glyphicon-th"></span> Rio Grande do Sul</a></li>
                            <li><a href="../volumes/?c=4" target="_blank"><span class="glyphicon glyphicon-th"></span> Mercosul</a></li>
                            <li><a href="../volumes/"     target="_blank"><span class="glyphicon glyphicon-th"></span> Todos (Consolidado)</a></li>
                            <?php endif; ?>            
                        </ul>
                    </li>
                <?php if($con->getIdFuncaoFuncionarioSessao() == 1 ):?>
                    <!-- li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-camera"></span> Cameras <b class="caret"></b></a>
                        <ul class="dropdown-menu">                    
                            <li><a href="../cameras/cameras.php" target="_blank"><span class="glyphicon glyphicon-th"></span> Todos Terminais</a></li>
                        </ul>
                    </li -->
                <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                   
                    <?php if($con->getIdFuncaoFuncionarioSessao() == 1 ):?>
                        <li><a href="../importar/importar.php"><span class="glyphicon glyphicon-upload"></span> Importar</a></li>
                    <?php endif; ?>
                    <li><a href="../configuracao/"><i class="fa fa-cogs"></i> Configura&ccedil;&otilde;es </a></li>
                   
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?= $con->getNomeFuncionarioSessao() ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="../../controller/services/sessao_controller.php?logout=logout"><span class="glyphicon glyphicon-log-out"></span> Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        <?php endif; ?>
    </div>    
</nav>