<?php require_once('config.php'); if(empty($_SESSION['key'])) { header ('location:./'); } $m = 3; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?php echo $cfg['titulo']; ?></title>
        <link rel="icon" type="image/png" href="img/favicon.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/ionicons.min.css">
        <link rel="stylesheet" href="css/smoke.min.css">
        <link rel="stylesheet" href="css/datatables.bootstrap.min.css">
        <link rel="stylesheet" href="css/datatables.responsive.bootstrap.min.css">
        <link rel="stylesheet" href="css/core.min.css">
        <link rel="stylesheet" href="css/skin-blue.min.css">
        <!--[if lt IE 9]><script src="js/html5shiv.min.js"></script><script src="js/respond.min.js"></script><![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header"><?php include_once('header.php'); ?></header>

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar"><?php include_once('sidebar.php'); ?></aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Tags <span class="pull-right lead response"><a data-toggle="modal" data-target="#nova-tag" href="#" title="Cadastre uma nova tag"><i class="fa fa-tag"></i> Nova tag</a></span></h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="box">
                        <div class="box-body">
                        <?php
                            include_once('conexao.php');

                            try {
                                $sql = $pdo->prepare("SELECT idtag,descricao FROM tag ORDER BY descricao");
                                $sql->execute();
                                $ret = $sql->rowCount();

                                    if($ret > 0) {
                                        $py = md5('idtag');

                                        echo'
                                        <table class="table table-bordered table-hover table-data dt-responsive nowrap">
                                            <thead>
                                                <th style="width: 50px;"></th>
                                                <th>Descri&ccedil;&atilde;o</th>
                                            </thead>
                                            <tbody>';

                                            while($lin = $sql->fetch(PDO::FETCH_OBJ)) {
                                                echo'
                                                <tr>
                                                    <td class="text-center">
                                                        <span><a data-toggle="modal" data-target="#edita-tag" data-placement="top" href="editaTag.php?'.$py.'='.$lin->idtag.'" title="Editar a tag"><i class="fa fa-pencil"></i></a></span>
                                                        <span><a data-toggle="tooltip" data-placement="top" href="#" class="delete-tag" id="'.$py.'-'.$lin->idtag.'" title="Excluir a tag"><i class="fa fa-trash-o"></i></a></span>
                                                    </td>
                                                    <td>'.$lin->descricao.'</td>
                                                </tr>';

                                                unset($sicon);
                                            }

                                        echo'
                                            </tbody>
                                            <tfoot>
                                                <th></th>
                                                <th>Descri&ccedil;&atilde;o</th>
                                            </tfoot>
                                        </table>';

                                        unset($lin);
                                    }
                                    else {
                                        echo'
                                        <div class="callout">
                                            <h4>Nada encontrado</h4>
                                            <p>Nenhuma tag foi cadastrada.</p>
                                        </div>';
                                    }

                                unset($pdo,$sql,$ret,$py);
                            }
                            catch(PDOException $e) {
                                echo 'Erro ao conectar o servidor '.$e->getMessage();
                            }
                        ?>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            <!-- Modal -->
            <div class="modal fade" id="nova-tag" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-nova-tag">
                            <div class="modal-header">
                                <button type="button" class="close closed" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Nova tag <small>(<i class="fa fa-asterisk"></i> Campo obrigat&oacute;rio)</small></h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="tag"><i class="fa fa-asterisk"></i> Tag</label>
                                    <input type="text" id="descricao" class="form-control" maxlength="45" title="Digite o nome da tag" placeholder="Tag" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-flat pull-left closed" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary btn-flat btn-submit-nova-tag">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edita-tag" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content"></div>
                </div>
            </div><!-- /.modal -->

            <!-- Main Footer -->
            <footer class="main-footer"><?php include_once('footer.php'); ?></footer>
        </div><!-- ./wrapper -->

        <script src="js/jquery-2.1.4.min.js"></script>
        <script defer src="js/bootstrap.min.js"></script>
        <script defer src="js/datatables.min.js"></script>
        <script defer src="js/datatables.bootstrap.min.js"></script>
        <script defer src="js/datatables.responsive.min.js"></script>
        <script defer src="js/datatables.responsive.bootstrap.min.js"></script>
        <script async src="js/smoke.min.js"></script>
        <script async src="js/core.min.js"></script>
    </body>
</html>
